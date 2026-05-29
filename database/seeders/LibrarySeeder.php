<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Kategoritë Kryesore ──────────────────────────────────────
        $cats = [
            ['emri' => 'Letërsi',          'pershkrimi' => 'Romane, novela, tregime dhe poezi'],
            ['emri' => 'Historia',          'pershkrimi' => 'Historia shqiptare dhe botërore'],
            ['emri' => 'Filozofi',          'pershkrimi' => 'Mendim filozofik dhe etikë'],
            ['emri' => 'Shkencë',           'pershkrimi' => 'Shkenca natyrore dhe ekzakte'],
            ['emri' => 'Fëmijë & Rini',    'pershkrimi' => 'Libra për fëmijë dhe të rinj'],
        ];

        foreach ($cats as $c) {
            DB::table('categories')->insertOrIgnore([
                'emri'               => $c['emri'],
                'pershkrimi'         => $c['pershkrimi'],
                'kategoria_prind_id' => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        // ── 2. Nënkategoritë ────────────────────────────────────────────
        $letërsi  = DB::table('categories')->where('emri', 'Letërsi')->value('id');
        $historia = DB::table('categories')->where('emri', 'Historia')->value('id');
        $femije   = DB::table('categories')->where('emri', 'Fëmijë & Rini')->value('id');

        $subcats = [
            ['emri' => 'Roman',         'pershkrimi' => 'Romane shqipe dhe të përkthyera',   'prind' => $letërsi],
            ['emri' => 'Poezi',         'pershkrimi' => 'Poezi klasike dhe bashkëkohore',     'prind' => $letërsi],
            ['emri' => 'Tregim',        'pershkrimi' => 'Tregime të shkurtra',                'prind' => $letërsi],
            ['emri' => 'Historia e Shqipërisë', 'pershkrimi' => 'Historia kombëtare',         'prind' => $historia],
            ['emri' => 'Mitologji',     'pershkrimi' => 'Mitologji shqiptare dhe ballkanike', 'prind' => $historia],
            ['emri' => 'Përralla',      'pershkrimi' => 'Përralla popullore shqipe',          'prind' => $femije],
        ];

        foreach ($subcats as $s) {
            DB::table('categories')->insertOrIgnore([
                'emri'               => $s['emri'],
                'pershkrimi'         => $s['pershkrimi'],
                'kategoria_prind_id' => $s['prind'],
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        // ── 3. Autorët Shqiptarë ────────────────────────────────────────
        $authors = [
            [
                'emri'      => 'Ismail',
                'mbiemri'   => 'Kadare',
                'biografia' => 'Ismail Kadare (lindur 1936, Gjirokastër) është shkrimtari më i shquar shqiptar i shekullit XX. Veprat e tij janë përkthyer në mbi 40 gjuhë. Fitues i çmimit Man Booker International 2005.',
            ],
            [
                'emri'      => 'Naim',
                'mbiemri'   => 'Frashëri',
                'biografia' => 'Naim Frashëri (1846–1900) është poeti kombëtar shqiptar dhe njëri nga ideologët kryesorë të Rilindjes Kombëtare Shqiptare. Veprat e tij kanë frymëzuar brezat.',
            ],
            [
                'emri'      => 'Fan',
                'mbiemri'   => 'Noli',
                'biografia' => 'Fan Stilian Noli (1882–1965), klerik, politikan dhe shkrimtar. Themelues i Kishës Ortodokse Shqiptare në Amerikë. Përkthen Shakespeare dhe Ibsen në shqip.',
            ],
            [
                'emri'      => 'Migjeni',
                'mbiemri'   => '',
                'biografia' => 'Millosh Gjergj Nikolla — Migjeni (1911–1938), poet dhe prozaist. Vepra e tij pasqyron realitetin e hidhur të Shqipërisë ndërmjet dy luftërave botërore.',
            ],
            [
                'emri'      => 'Dritëro',
                'mbiemri'   => 'Agolli',
                'biografia' => 'Dritëro Agolli (1931–2017), poet, prozaist dhe dramaturg shqiptar. Autor i shumë romaneve dhe vëllimeve poetike. Kryetar i Lidhjes së Shkrimtarëve për shumë vite.',
            ],
            [
                'emri'      => 'Gjergj',
                'mbiemri'   => 'Fishta',
                'biografia' => 'Gjergj Fishta (1871–1940), poet dhe klerik françeskan. Autori i "Lahutës së Malsisë", eposit kombëtar shqiptar, quhet "homeri shqiptar".',
            ],
            [
                'emri'      => 'Faik',
                'mbiemri'   => 'Konica',
                'biografia' => 'Faik Konica (1875–1942), shkrimtar, publicist dhe diplomat. Redaktor i revistës "Albania" dhe ambasador i Shqipërisë në SHBA.',
            ],
        ];

        foreach ($authors as $a) {
            DB::table('authors')->insertOrIgnore([
                'emri'       => $a['emri'],
                'mbiemri'    => $a['mbiemri'],
                'biografia'  => $a['biografia'],
                'foto_autori'=> null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ── 4. Librat Shqiptarë ─────────────────────────────────────────
        $kadare  = DB::table('authors')->where('emri', 'Ismail')->value('id');
        $naim    = DB::table('authors')->where('emri', 'Naim')->value('id');
        $migjeni = DB::table('authors')->where('emri', 'Migjeni')->value('id');
        $agolli  = DB::table('authors')->where('emri', 'Dritëro')->value('id');
        $fishta  = DB::table('authors')->where('emri', 'Gjergj')->value('id');

        $roman   = DB::table('categories')->where('emri', 'Roman')->value('id');
        $poezi   = DB::table('categories')->where('emri', 'Poezi')->value('id');
        $tregim  = DB::table('categories')->where('emri', 'Tregim')->value('id');
        $hist_sh = DB::table('categories')->where('emri', 'Historia e Shqipërisë')->value('id');

        $books = [
            [
                'titulli'     => 'Gjenerali i Ushtrisë së Vdekur',
                'isbn'        => '978-9928-05-001-1',
                'cmimi'       => 12.50,
                'sasia'       => 25,
                'author_id'   => $kadare,
                'category_id' => $roman,
                'pershkrimi'  => 'Romani i parë i Kadaresë. Një gjeneral italian dhe një prift vijnë në Shqipëri pas Luftës II Botërore për të mbledhur eshtrat e ushtarëve të rënë.',
            ],
            [
                'titulli'     => 'Kështjella',
                'isbn'        => '978-9928-05-002-2',
                'cmimi'       => 11.00,
                'sasia'       => 18,
                'author_id'   => $kadare,
                'category_id' => $roman,
                'pershkrimi'  => 'Roman historik që rikrijonte rezistencën e shqiptarëve ndaj pushtimit osman në shekullin XV.',
            ],
            [
                'titulli'     => 'Prilli i Thyer',
                'isbn'        => '978-9928-05-003-3',
                'cmimi'       => 10.00,
                'sasia'       => 20,
                'author_id'   => $kadare,
                'category_id' => $roman,
                'pershkrimi'  => 'Tregon historinë tragjike të një djali të ri nga Malësia e Veriut, i zënë në gjakmarrje.',
            ],
            [
                'titulli'     => 'Kronikë në Gur',
                'isbn'        => '978-9928-05-004-4',
                'cmimi'       => 9.50,
                'sasia'       => 15,
                'author_id'   => $kadare,
                'category_id' => $roman,
                'pershkrimi'  => 'Roman autobiografik që përshkruan fëmijërinë e autorit në Gjirokastër gjatë Luftës II Botërore.',
            ],
            [
                'titulli'     => 'Lulet e Verës',
                'isbn'        => '978-9928-06-001-5',
                'cmimi'       => 8.00,
                'sasia'       => 30,
                'author_id'   => $naim,
                'category_id' => $poezi,
                'pershkrimi'  => 'Vëllimi poetik më i njohur i Naim Frashërit, me poezi lirike plot ndjenjë dhe dashuri për atdheun.',
            ],
            [
                'titulli'     => 'Bagëti e Bujqësia',
                'isbn'        => '978-9928-06-002-6',
                'cmimi'       => 7.50,
                'sasia'       => 22,
                'author_id'   => $naim,
                'category_id' => $poezi,
                'pershkrimi'  => 'Poema e parë e Naim Frashërit, kushtuar jetës bujqësore dhe natyrës shqiptare.',
            ],
            [
                'titulli'     => 'Vargjet e Lira',
                'isbn'        => '978-9928-07-001-7',
                'cmimi'       => 9.00,
                'sasia'       => 14,
                'author_id'   => $migjeni,
                'category_id' => $poezi,
                'pershkrimi'  => 'Vëllimi i vetëm poetik i Migjenit, botuar në 1936. Poezi rreth varfërisë, dhimbjes dhe protestës sociale.',
            ],
            [
                'titulli'     => 'Novela të Qytetit të Veriut',
                'isbn'        => '978-9928-07-002-8',
                'cmimi'       => 8.50,
                'sasia'       => 16,
                'author_id'   => $migjeni,
                'category_id' => $tregim,
                'pershkrimi'  => 'Tregime të shkurtra që pasqyrojnë jetën e varfër të Shkodrës në vitet 30.',
            ],
            [
                'titulli'     => 'Njeriu me top',
                'isbn'        => '978-9928-08-001-9',
                'cmimi'       => 10.50,
                'sasia'       => 19,
                'author_id'   => $agolli,
                'category_id' => $roman,
                'pershkrimi'  => 'Romani satirik i Dritëro Agollit, humor i hollë dhe kritikë shoqërore.',
            ],
            [
                'titulli'     => 'Komisari Memo',
                'isbn'        => '978-9928-08-002-0',
                'cmimi'       => 9.00,
                'sasia'       => 12,
                'author_id'   => $agolli,
                'category_id' => $roman,
                'pershkrimi'  => 'Roman historik që përshkruan periudhën e çlirimit të Shqipërisë.',
            ],
        ];

        foreach ($books as $b) {
            DB::table('books')->insertOrIgnore([
                'titulli'     => $b['titulli'],
                'isbn'        => $b['isbn'],
                'cmimi'       => $b['cmimi'],
                'sasia'       => $b['sasia'],
                'author_id'   => $b['author_id'],
                'category_id' => $b['category_id'],
                'pershkrimi'  => $b['pershkrimi'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info('✓ Kategoritë, nënkategoritë, autorët dhe librat u shtuan me sukses!');
    }
}
