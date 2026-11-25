import unittest

import pandas as pd

from main import evaluasi_silang


class EvaluasiSilangTests(unittest.TestCase):
    def setUp(self):
        self.features = pd.DataFrame({"ipk": [2.0, 2.2, 3.5, 3.8]})

    def test_evaluasi_silang_returns_metrics_for_two_classes(self):
        result = evaluasi_silang(
            self.features,
            pd.Series([0, 0, 1, 1]),
            n_estimators=10,
            max_depth=3,
            random_state=42,
        )

        self.assertEqual(result["folds"], 2)
        self.assertEqual(result["samples"], 4)
        self.assertIsNotNone(result["accuracy"])
        self.assertEqual(sum(map(sum, result["confusion_matrix"]["matrix"])), 4)
        self.assertIsNotNone(result["warning"])

    def test_evaluasi_silang_does_not_report_metrics_with_insufficient_classes(self):
        result = evaluasi_silang(
            self.features,
            pd.Series([0, 0, 0, 1]),
            n_estimators=10,
            max_depth=None,
            random_state=42,
        )

        self.assertIsNone(result["accuracy"])
        self.assertEqual(result["folds"], 0)
        self.assertIn("minimal dua kelas", result["warning"])


if __name__ == "__main__":
    unittest.main()
