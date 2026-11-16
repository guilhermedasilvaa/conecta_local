<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\BrazilianStates;

class AddProfessionalProfileState extends Migration
{
    public function up()
    {
        $this->forge->addColumn('professional_profiles', [
            'state' => [
                'type'       => 'CHAR',
                'constraint' => 2,
                'null'       => true,
                'after'      => 'city',
            ],
        ]);

        $profiles = $this->db->table('professional_profiles')
            ->select('id, city')
            ->get()
            ->getResultArray();

        foreach ($profiles as $profile) {
            $city = trim((string) $profile['city']);

            if (! preg_match('/\s*(?:-|\/|,)\s*([A-Za-z]{2})\s*$/u', $city, $matches)) {
                continue;
            }

            $state = strtoupper($matches[1]);

            if (! isset(BrazilianStates::STATES[$state])) {
                continue;
            }

            $normalizedCity = trim(substr($city, 0, -strlen($matches[0])));

            if ($normalizedCity === '') {
                continue;
            }

            $this->db->table('professional_profiles')
                ->where('id', (int) $profile['id'])
                ->update([
                    'city'  => $normalizedCity,
                    'state' => $state,
                ]);
        }
    }

    public function down()
    {
        $profiles = $this->db->table('professional_profiles')
            ->select('id, city, state')
            ->where('state IS NOT NULL', null, false)
            ->get()
            ->getResultArray();

        foreach ($profiles as $profile) {
            $this->db->table('professional_profiles')
                ->where('id', (int) $profile['id'])
                ->update([
                    'city' => trim((string) $profile['city']) . ' - ' . strtoupper((string) $profile['state']),
                ]);
        }

        $this->forge->dropColumn('professional_profiles', 'state');
    }
}
