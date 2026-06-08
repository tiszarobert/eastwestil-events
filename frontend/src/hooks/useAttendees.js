import { useEffect, useState } from "react";
const API = import.meta.env.VITE_API_URL || "http://localhost:8000/api";

export function useAttendees(eventId, open) {
  const [attendees, setAttendees] = useState([]);
  const [loading, setLoading] = useState(false);

  const load = () => {
    if (!open) return;
    setLoading(true);
    fetch(`${API}/events/${eventId}/attendees`)
      .then((r) => r.json())
      .then((j) => setAttendees(j.data || []))
      .catch(() => {})
      .finally(() => setLoading(false));
  };

  useEffect(load, [open, eventId]);

  const addAttendee = (a) => setAttendees((prev) => [...prev, a]);
  return { attendees, loading, addAttendee };
}