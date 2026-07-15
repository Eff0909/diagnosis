import { useEffect, useState } from "react";
import SymptomForm from "./components/SymptomForm";
import ResultCard from "./components/ResultCard";
import "./App.css";

const API_BASE = "http://localhost:8000/api";

export default function App() {
  const [symptoms, setSymptoms] = useState([]);
  const [selected, setSelected] = useState([]);
  const [result, setResult] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetch(`${API_BASE}/symptoms`)
      .then((res) => res.json())
      .then((data) => setSymptoms(data.symptoms))
      .catch(() => setError("Gagal memuat daftar gejala. Pastikan backend Laravel sudah berjalan."));
  }, []);

  const toggleSymptom = (key) => {
    setSelected((prev) =>
      prev.includes(key) ? prev.filter((s) => s !== key) : [...prev, key]
    );
  };

  const handleDiagnose = async () => {
    if (selected.length === 0) {
      setError("Pilih minimal satu gejala terlebih dahulu.");
      return;
    }
    setError(null);
    setLoading(true);
    try {
      const res = await fetch(`${API_BASE}/diagnose`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ symptoms: selected }),
      });
      if (!res.ok) throw new Error("Request gagal");
      const data = await res.json();
      setResult(data);
    } catch (err) {
      setError("Terjadi kesalahan saat memproses diagnosis.");
    } finally {
      setLoading(false);
    }
  };

  const handleReset = () => {
    setSelected([]);
    setResult(null);
    setError(null);
  };

  return (
    <div className="app-shell">
      <header className="app-header">
        <h1>SIDx — Sistem Diagnosis Penyakit</h1>
        <p>Klasifikasi gejala menggunakan algoritma Naive Bayes</p>
      </header>

      <main className="app-main">
        <SymptomForm
          symptoms={symptoms}
          selected={selected}
          onToggle={toggleSymptom}
        />

        <div className="action-row">
          <button className="btn-primary" onClick={handleDiagnose} disabled={loading}>
            {loading ? "Memproses..." : "Diagnosis Sekarang"}
          </button>
          <button className="btn-secondary" onClick={handleReset}>
            Reset
          </button>
        </div>

        {error && <p className="error-text">{error}</p>}

        {result && <ResultCard result={result} />}
      </main>
    </div>
  );
}
