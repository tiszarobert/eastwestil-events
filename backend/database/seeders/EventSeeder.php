<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        if (Event::count() > 0) {
            $this->command->info('EventSeeder: Az adatbázis már tartalmaz adatokat, kihagyva.');
            return;
        }
        $events = [
            [
                'title'    => 'Laravel Budapest Meetup',
                'date'     => '2025-03-15',
                'location' => 'Budapest, Magyar Tudományos Akadémia',
            ],
            [
                'title'    => 'PHP Conference Hungary 2025',
                'date'     => '2025-04-22',
                'location' => 'Budapest, Corinthia Hotel',
            ],
            [
                'title'    => 'Vue.js & Inertia Workshop',
                'date'     => '2025-05-10',
                'location' => 'Online (Zoom)',
            ],
            [
                'title'    => 'API Design Best Practices',
                'date'     => '2025-06-05',
                'location' => 'Budapest, IH Budapest',
            ],
            [
                'title'    => 'DevOps & Docker Bootcamp',
                'date'     => '2025-07-18',
                'location' => 'Debrecen, Debreceni Egyetem',
            ],
        ];

        foreach ($events as $eventData) {
            $event = Event::create($eventData);

            // Minden eseményhez adjunk hozzá 2 teszt résztvevőt
            Attendee::create([
                'event_id' => $event->id,
                'name'     => 'Kovács János',
                'email'    => 'kovacs.janos@example.com',
            ]);

            Attendee::create([
                'event_id' => $event->id,
                'name'     => 'Nagy Éva',
                'email'    => 'nagy.eva@example.com',
            ]);
        }

        $this->command->info('EventSeeder: 5 esemény és 10 résztvevő sikeresen létrehozva.');
    }
}
