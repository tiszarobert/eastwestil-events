import { useEffect, useState } from "react";
import { RegistrationForm } from "./RegistrationForm";
import { useAttendees } from "../hooks/useAttendees";

const API = import.meta.env.VITE_API_URL || "http://localhost:8000/api";

function formatDate(d) {
  return new Date(d).toLocaleDateString("hu-HU", {
    year: "numeric", month: "long", day: "numeric",
  });
}

export function EventAccordionItem({ event, index, openId, setOpenId }) {
  const isOpen = openId === event.id;
  const { attendees, loading, addAttendee } = useAttendees(event.id, isOpen);

  return (
    <div className="accordion-item">
      <h2 className="accordion-header">
        <button
          className={`accordion-button ${isOpen ? "" : "collapsed"}`}
          type="button"
          onClick={() => setOpenId(isOpen ? null : event.id)}
        >
          <div className="d-flex align-items-center gap-3 w-100 me-3">
            <span className="badge bg-dark rounded-pill" style={{ minWidth: 28 }}>
              {index + 1}
            </span>
            <div>
              <div className="fw-semibold">{event.title}</div>
              <div className="text-muted small">
                {formatDate(event.date)}
                {event.location && <> &middot; {event.location}</>}
              </div>
            </div>
            <span className="badge bg-secondary ms-auto">
              {(attendees.length ? attendees.length  : event.attendees_count)} résztvevő
            </span>
          </div>
        </button>
      </h2>

      {isOpen && (
        <div className="accordion-collapse">
          <div className="accordion-body">
            {loading ? (
              <p className="text-muted small mb-0">Betöltés...</p>
            ) : event.attendees_count == 0 ? (
              <p className="text-muted small mb-0">Még nincs regisztrált résztvevő.</p>
            ) : (
              <ul className="list-group list-group-flush mb-2">
                {attendees.map((a) => (
                  <li
                    key={a.id}
                    className="list-group-item px-0 py-2 d-flex align-items-center gap-2"
                  >
                    <span
                      className="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center flex-shrink-0"
                      style={{ width: 30, height: 30, fontSize: 13 }}
                    >
                      {a.name.charAt(0).toUpperCase()}
                    </span>
                    <span className="fw-medium small">{a.name}</span>
                    <span className="text-muted small ms-auto">{a.email}</span>
                  </li>
                ))}
              </ul>
            )}

            <hr className="my-3" />
            <RegistrationForm eventId={event.id} onSuccess={addAttendee} />
          </div>
        </div>
      )}
    </div>
  );
}