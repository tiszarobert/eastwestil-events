import { useEffect, useState } from "react";

const API = import.meta.env.VITE_API_URL || "http://localhost:8000/api";

export function useEvents() {
  const [events, setEvents] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const load = () => {
    setLoading(true);
    fetch(`${API}/events`)
      .then((r) => r.json())
      .then((j) => setEvents(j.data || []))
      .catch(() => setError("Nem sikerült betölteni az eseményeket."))
      .finally(() => setLoading(false));
  };

  useEffect(load, []);
  return { events, loading, error, reload: load };
}