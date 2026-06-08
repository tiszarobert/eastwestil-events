import { useEffect, useState } from "react";
import { useEvents } from './hooks/useEvents'
import { EventAccordionItem } from "./components/EventAccordionItem";

const API = import.meta.env.VITE_API_URL || "http://localhost:8000/api";
const PER_PAGE = 10;




export default function App() {
  const { events, loading, error } = useEvents();
  const [openId, setOpenId] = useState(null);
  const [page, setPage] = useState(1);

  const totalPages = Math.ceil(events.length / PER_PAGE);
  const pageEvents = events.slice((page - 1) * PER_PAGE, page * PER_PAGE);

  const changePage = (p) => {
    setPage(p);
    setOpenId(null);
  };

  return (
    <div className="min-vh-100 bg-light">
      <nav className="navbar navbar-dark bg-dark">
        <div className="container">
          <div className="navbar-brand fw-bold mx-auto">Eastwestil Events</div>
        </div>
      </nav>

      <div className="container py-5" style={{ maxWidth: 760 }}>
        <div className="mb-4 d-flex align-items-baseline gap-3">
          <h1 className="h3 fw-bold mb-0">Események</h1>
          {!loading && (
            <span className="text-muted small">{events.length} esemény</span>
          )}
        </div>

        {loading && (
          <div className="text-center py-5 text-muted">Betöltés...</div>
        )}
        {error && (
          <div className="alert alert-danger">{error}</div>
        )}

        {!loading && !error && (
          <>
            <div className="accordion shadow-sm">
              {pageEvents.map((ev, i) => (
                <EventAccordionItem
                  key={ev.id}
                  event={ev}
                  index={(page - 1) * PER_PAGE + i}
                  openId={openId}
                  setOpenId={setOpenId}
                />
              ))}
            </div>

            {totalPages > 1 && (
              <nav className="mt-4 d-flex justify-content-center">
                <ul className="pagination mb-0">
                  {Array.from({ length: totalPages }, (_, i) => i + 1).map((p) => (
                    <li
                      key={p}
                      className={`page-item ${page === p ? "active" : ""}`}
                    >
                      <button
                        className="page-link"
                        onClick={() => changePage(p)}
                      >
                        {p}
                      </button>
                    </li>
                  ))}
                </ul>
              </nav>
            )}
          </>
        )}
      </div>
    </div>
  );
}
