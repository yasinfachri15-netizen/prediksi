from datetime import datetime
import json
import os
from typing import Any

import joblib
import numpy as np
import pandas as pd
from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score, confusion_matrix, f1_score, precision_score, recall_score
from sklearn.model_selection import StratifiedKFold, cross_val_predict

app = FastAPI(title="ML Service Prediksi Kelulusan")

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
MODEL_FILE = os.path.join(BASE_DIR, "model_rf.joblib")
META_FILE = os.path.join(BASE_DIR, "model_meta.json")
FITUR = [
    "ipk",
    "rasio_sks_lulus",
    "jumlah_e",
    "jumlah_d_cd",
    "jumlah_c",
    "rata_rata_inti",
]


class DataLatihItem(BaseModel):
    ipk: float
    sks_diambil: int
    sks_lulus: int
    jumlah_e: int
    jumlah_d_cd: int
    jumlah_c: int
    rata_rata_inti: float
    status_kelulusan: int


class TrainRequest(BaseModel):
    data_latih: list[DataLatihItem]
    n_estimators: int = 100
    max_depth: int | None = None
    random_state: int = 42
    dilatih_oleh: str = "admin"


class MahasiswaItem(BaseModel):
    id: int | None = None
    ipk: float
    sks_diambil: int
    sks_lulus: int
    jumlah_e: int
    jumlah_d_cd: int
    jumlah_c: int
    rata_rata_inti: float


class PredictRequest(BaseModel):
    items: list[MahasiswaItem]


def siapkan_df(items: list[dict[str, Any]]) -> pd.DataFrame:
    df = pd.DataFrame(items)
    if len(df) == 0:
        return pd.DataFrame(columns=FITUR)
    sks_aman = df["sks_diambil"].replace(0, np.nan)
    df["rasio_sks_lulus"] = (df["sks_lulus"] / sks_aman).fillna(0.0).clip(0.0, 1.0)
    return df


def muat_model():
    if not os.path.exists(MODEL_FILE):
        raise HTTPException(status_code=400, detail="Model belum dilatih. Silakan latih model terlebih dahulu.")
    model = joblib.load(MODEL_FILE)
    meta = {}
    if os.path.exists(META_FILE):
        with open(META_FILE, "r", encoding="utf-8") as f:
            meta = json.load(f)
    return model, meta


def prob_lulus(model, probs: np.ndarray) -> np.ndarray:
    classes = list(getattr(model, "classes_", []))
    if 1 in classes:
        return probs[:, classes.index(1)]
    return np.ones(len(probs)) if (len(classes) > 0 and classes[0] == 1) else np.zeros(len(probs))


def evaluasi_silang(
    X: pd.DataFrame,
    y: pd.Series,
    n_estimators: int,
    max_depth: int | None,
    random_state: int,
) -> dict[str, Any]:
    jumlah_per_kelas = y.value_counts()
    jumlah_fold = min(5, int(jumlah_per_kelas.min())) if not jumlah_per_kelas.empty else 0

    if len(jumlah_per_kelas) < 2 or jumlah_fold < 2:
        return {
            "method": None,
            "folds": 0,
            "samples": len(y),
            "accuracy": None,
            "precision": None,
            "recall": None,
            "f1_score": None,
            "confusion_matrix": None,
            "warning": "Evaluasi memerlukan minimal dua kelas dengan sedikitnya dua data per kelas.",
        }

    cv = StratifiedKFold(n_splits=jumlah_fold, shuffle=True, random_state=random_state)
    estimator = RandomForestClassifier(
        n_estimators=n_estimators,
        max_depth=max_depth,
        random_state=random_state,
    )
    prediksi_uji = cross_val_predict(estimator, X, y, cv=cv)
    label = [0, 1]
    matrix = confusion_matrix(y, prediksi_uji, labels=label)

    return {
        "method": f"Stratified {jumlah_fold}-fold cross-validation",
        "folds": jumlah_fold,
        "samples": len(y),
        "accuracy": round(float(accuracy_score(y, prediksi_uji)) * 100.0, 2),
        "precision": round(float(precision_score(y, prediksi_uji, pos_label=1, zero_division=0)) * 100.0, 2),
        "recall": round(float(recall_score(y, prediksi_uji, pos_label=1, zero_division=0)) * 100.0, 2),
        "f1_score": round(float(f1_score(y, prediksi_uji, pos_label=1, zero_division=0)) * 100.0, 2),
        "confusion_matrix": {
            "labels": ["Belum lulus", "Lulus"],
            "matrix": matrix.astype(int).tolist(),
        },
        "warning": (
            "Data sangat terbatas; metrik evaluasi ini hanya indikatif."
            if len(y) < 20
            else None
        ),
    }


@app.post("/train")
def train_model(req: TrainRequest):
    if len(req.data_latih) < 2:
        raise HTTPException(status_code=400, detail="Data latih minimal 2 baris.")

    rows = [d.model_dump() for d in req.data_latih]
    df = siapkan_df(rows)
    X = df[FITUR]
    y = df["status_kelulusan"].astype(int)

    model = RandomForestClassifier(
        n_estimators=req.n_estimators,
        max_depth=req.max_depth,
        random_state=req.random_state,
    )
    model.fit(X, y)

    akurasi = float(accuracy_score(y, model.predict(X))) * 100.0
    evaluasi = evaluasi_silang(
        X,
        y,
        n_estimators=req.n_estimators,
        max_depth=req.max_depth,
        random_state=req.random_state,
    )
    importance = [
        {"fitur": f, "importance": round(float(imp), 4)}
        for f, imp in sorted(zip(FITUR, model.feature_importances_), key=lambda x: x[1], reverse=True)
    ]

    meta = {
        "waktu_latih": datetime.now().strftime("%Y-%m-%d %H:%M:%S"),
        "dilatih_oleh": req.dilatih_oleh,
        "jumlah_data_latih": len(df),
        "n_estimators": req.n_estimators,
        "max_depth": req.max_depth,
        "random_state": req.random_state,
        "akurasi_latih": round(akurasi, 2),
        "evaluasi": evaluasi,
        "feature_importance": importance,
    }

    joblib.dump(model, MODEL_FILE)
    with open(META_FILE, "w", encoding="utf-8") as f:
        json.dump(meta, f, indent=2, ensure_ascii=False)

    return {"status": "ok", "metadata": meta}


@app.post("/predict")
def predict_batch(req: PredictRequest):
    model, meta = muat_model()
    if len(req.items) == 0:
        return {"predictions": [], "metadata": meta}

    rows = [m.model_dump() for m in req.items]
    df = siapkan_df(rows)
    preds = model.predict(df[FITUR])
    peluang = prob_lulus(model, model.predict_proba(df[FITUR])) * 100.0

    hasil = []
    for idx, item in enumerate(rows):
        p = int(preds[idx])
        prob = round(float(peluang[idx]), 1)
        hasil.append({
            "id": item.get("id"),
            "rasio_sks_lulus": round(float(df.iloc[idx]["rasio_sks_lulus"]), 2),
            "peluang_lulus": prob,
            "status_prediksi": "Berpotensi Lulus Tepat Waktu" if p == 1 else "Berisiko Terlambat / DO",
            "prediksi_kelas": p,
        })

    return {"predictions": hasil, "metadata": meta}
