export default function SymptomForm({ symptoms, selected, onToggle }) {
  return (
    <section className="symptom-form">
      <h2>Pilih Gejala yang Dirasakan</h2>
      <div className="symptom-grid">
        {symptoms.map((s) => (
          <label key={s.key} className={`symptom-item ${selected.includes(s.key) ? "active" : ""}`}>
            <input
              type="checkbox"
              checked={selected.includes(s.key)}
              onChange={() => onToggle(s.key)}
            />
            <span>{s.label}</span>
          </label>
        ))}
      </div>
    </section>
  );
}
