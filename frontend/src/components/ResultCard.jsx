export default function ResultCard({ result }) {
  const { top_diagnosis: top, result: all } = result;

  return (
    <section className="result-card">
      <h2>Hasil Diagnosis</h2>

      <div className="top-result">
        <p className="top-label">Kemungkinan Terbesar</p>
        <h3>{top.label}</h3>
        <p className="top-prob">{top.probability}%</p>
      </div>

      <div className="prob-breakdown">
        <p className="breakdown-title">Rincian Probabilitas Tiap Penyakit</p>
        {all.map((r) => (
          <div key={r.disease} className="prob-row">
            <span className="prob-name">{r.label}</span>
            <div className="prob-bar-track">
              <div className="prob-bar-fill" style={{ width: `${r.probability}%` }} />
            </div>
            <span className="prob-value">{r.probability}%</span>
          </div>
        ))}
      </div>

      <p className="disclaimer">
        *Hasil ini merupakan simulasi klasifikasi data mining untuk keperluan
        akademik, bukan diagnosis medis resmi. Konsultasikan ke dokter untuk
        pemeriksaan sesungguhnya.
      </p>
    </section>
  );
}
