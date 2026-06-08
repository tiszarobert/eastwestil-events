import { useEffect, useState } from "react";

const API = import.meta.env.VITE_API_URL || "http://localhost:8000/api";


export function RegistrationForm({ eventId, onSuccess }) {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [errors, setErrors] = useState({});
  const [submitting, setSubmitting] = useState(false);
  const [success, setSuccess] = useState(false);

  const submit = async (e) => {
    e.preventDefault();
    setErrors({});
    setSuccess(false);
    setSubmitting(true);
    try {
      const res = await fetch(`${API}/events/${eventId}/register`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ name, email }),
      });
      const json = await res.json();
      if (!res.ok) { setErrors(json.errors || { general: json.message }); return; }
      setName(""); setEmail(""); setSuccess(true);
      onSuccess(json.data.attendee);
    } catch {
      setErrors({ general: "Hálózati hiba, próbáld újra." });
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <form onSubmit={submit} noValidate className="mt-3">
      <h6 className="fw-semibold mb-3">Regisztráció</h6>

      {errors.general && (
        <div className="alert alert-danger py-2 small">{errors.general}</div>
      )}
      {success && (
        <div className="alert alert-success py-2 small">Sikeresen regisztráltál!</div>
      )}

      <div className="row g-2">
        <div className="col-md-5">
          <input
            type="text"
            className={`form-control form-control-sm ${errors.name ? "is-invalid" : ""}`}
            placeholder="Teljes név *"
            value={name}
            onChange={(e) => setName(e.target.value)}
            disabled={submitting}
          />
          {errors.name && <div className="invalid-feedback">{errors.name[0]}</div>}
        </div>
        <div className="col-md-5">
          <input
            type="email"
            className={`form-control form-control-sm ${errors.email ? "is-invalid" : ""}`}
            placeholder="Email cím *"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            disabled={submitting}
          />
          {errors.email && <div className="invalid-feedback">{errors.email[0]}</div>}
        </div>
        <div className="col-md-2">
          <button
            type="submit"
            className="btn btn-dark btn-sm w-100"
            disabled={submitting}
          >
            {submitting ? "..." : "Küldés"}
          </button>
        </div>
      </div>
    </form>
  );
}