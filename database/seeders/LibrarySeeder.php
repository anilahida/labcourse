<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Category;
use App\Models\Book;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        // ── 10 Kategori ────────────────────────────────────────────────
        $catNames = [
            'Letërsi','Histori','Filozofi','Shkencë',
            'Teknologji','Psikologji','Biznes','Arte','Poezi','Roman',
        ];
        $catIds = [];
        foreach ($catNames as $name) {
            $c = Category::firstOrCreate(['emri' => $name], ['pershkrimi' => '']);
            $catIds[$name] = $c->id;
        }

        // ── 30 Autorë ──────────────────────────────────────────────────
        $authorList = [
            ['Ismail','Kadare'],      ['Naim','Frashëri'],
            ['Migjeni',''],           ['Dritëro','Agolli'],
            ['Faik','Konica'],        ['Fan','Noli'],
            ['Gjergj','Fishta'],      ['Petro','Marko'],
            ['Sabri','Godo'],         ['Teodor','Laço'],
            ['George','Orwell'],      ['Franz','Kafka'],
            ['Leo','Tolstoy'],        ['Fyodor','Dostoevsky'],
            ['Victor','Hugo'],        ['Albert','Camus'],
            ['Ernest','Hemingway'],   ['Gabriel','García Márquez'],
            ['Paulo','Coelho'],       ['Haruki','Murakami'],
            ['James','Clear'],        ['Dale','Carnegie'],
            ['Napoleon','Hill'],      ['Yuval','Harari'],
            ['Stephen','Hawking'],    ['Carl','Sagan'],
            ['Sigmund','Freud'],      ['Carl','Jung'],
            ['Friedrich','Nietzsche'],['Plato',''],
        ];
        foreach ($authorList as $a) {
            Author::firstOrCreate(['emri' => $a[0],'mbiemri' => $a[1]], ['biografia' => '']);
        }

        // ── 100 Libra ──────────────────────────────────────────────────
        // [titulli, emri_autorit, mbiemri_autorit, kategoria, cmimi, sasia, isbn]
        $books = [
            ['Gjenerali i Ushtrisë së Vdekur','Ismail','Kadare','Letërsi',12.50,15,'978-9928-08-101'],
            ['Kështjella','Ismail','Kadare','Letërsi',11.00,10,'978-9928-08-102'],
            ['Prilli i Thyer','Ismail','Kadare','Letërsi',10.00,20,'978-9928-08-103'],
            ['Kronikë në Gur','Ismail','Kadare','Letërsi',9.50,12,'978-9928-08-104'],
            ['Pallati i Endrrave','Ismail','Kadare','Letërsi',20.00,8,'978-9928-08-105'],
            ['Spiritus','Ismail','Kadare','Letërsi',14.00,18,'978-9928-08-106'],
            ['Ura me tre harqe','Ismail','Kadare','Roman',18.00,14,'978-9928-08-107'],
            ['Lulet e Verës','Naim','Frashëri','Poezi',8.00,25,'978-9928-08-108'],
            ['Bagëti e Bujqësia','Naim','Frashëri','Poezi',7.50,30,'978-9928-08-109'],
            ['Historia e Skënderbeut','Naim','Frashëri','Histori',9.00,14,'978-9928-08-110'],
            ['Vargjet e Lira','Migjeni','','Poezi',9.00,16,'978-9928-08-111'],
            ['Novela të Qytetit të Veriut','Migjeni','','Letërsi',8.50,11,'978-9928-08-112'],
            ['Njeriu me top','Dritëro','Agolli','Letërsi',10.50,19,'978-9928-08-113'],
            ['Komisari Memo','Dritëro','Agolli','Letërsi',9.00,22,'978-9928-08-114'],
            ['Shkelqimi dhe Rënia e shokut Zylo','Dritëro','Agolli','Letërsi',11.00,7,'978-9928-08-115'],
            ['Retë dhe Gurët','Dritëro','Agolli','Poezi',8.00,25,'978-9928-08-116'],
            ['Lahuta e Malcis','Gjergj','Fishta','Poezi',12.00,9,'978-9928-08-117'],
            ['Gjon Urani','Petro','Marko','Roman',10.00,14,'978-9928-08-118'],
            ['Hasta la Vista','Sabri','Godo','Roman',9.50,16,'978-9928-08-119'],
            ['Zonja nga qyteti','Teodor','Laço','Roman',8.50,11,'978-9928-08-120'],
            ['1984','George','Orwell','Roman',15.00,30,'978-0-452-28423'],
            ['Ferma e Kafshëve','George','Orwell','Letërsi',12.00,25,'978-0-451-52634'],
            ['Metamorfoza','Franz','Kafka','Letërsi',10.00,20,'978-0-486-29030'],
            ['Gjykimi','Franz','Kafka','Letërsi',11.00,15,'978-0-805-21733'],
            ['Ana Karenina','Leo','Tolstoy','Roman',18.00,12,'978-0-140-44920'],
            ['Lufta dhe Paqja','Leo','Tolstoy','Roman',22.00,8,'978-0-307-26693'],
            ['Idioti','Fyodor','Dostoevsky','Roman',14.00,17,'978-0-142-18238'],
            ['Krimi dhe Ndëshkimi','Fyodor','Dostoevsky','Roman',16.00,21,'978-0-140-44913'],
            ['Mjerables','Victor','Hugo','Roman',20.00,9,'978-0-140-44430'],
            ['Njeriu i Huaj','Albert','Camus','Letërsi',11.00,22,'978-0-679-72020'],
            ['Plaku dhe Deti','Ernest','Hemingway','Roman',12.00,18,'978-0-684-80122'],
            ['Njëqind Vjet Vetmi','Gabriel','García Márquez','Roman',17.00,14,'978-0-06-093417'],
            ['Kimisti','Paulo','Coelho','Letërsi',13.00,35,'978-0-06-112241'],
            ['Kafkë në Bregdet','Haruki','Murakami','Roman',16.00,19,'978-0-099-49430'],
            ['Norvegjeze Dru','Haruki','Murakami','Roman',14.00,23,'978-0-099-44803'],
            ['Republika','Plato','','Filozofi',15.00,12,'978-0-140-45511'],
            ['Nikomakike Etike','Plato','','Filozofi',14.00,10,'978-0-140-44949'],
            ['Kjo Foli Zarathustra','Friedrich','Nietzsche','Filozofi',13.00,15,'978-0-140-44118'],
            ['Humbja e Vlerave','Friedrich','Nietzsche','Filozofi',12.00,11,'978-0-679-72462'],
            ['Interpretimi i Ëndrrave','Sigmund','Freud','Psikologji',16.00,14,'978-0-465-01921'],
            ['Tipi Psikologjik','Carl','Jung','Psikologji',15.00,13,'978-0-691-09770'],
            ['Njeriu dhe Simbolet','Carl','Jung','Psikologji',14.00,16,'978-0-440-35183'],
            ['Sapiens','Yuval','Harari','Histori',19.00,28,'978-0-062-31609'],
            ['Homo Deus','Yuval','Harari','Histori',18.00,22,'978-0-062-46473'],
            ['21 Mësime për Shekullin 21','Yuval','Harari','Filozofi',17.00,19,'978-0-525-51217'],
            ['Historia e Shkurtër e Kohës','Stephen','Hawking','Shkencë',16.00,20,'978-0-553-38016'],
            ['Universi në Lëvozhgën e Arrës','Stephen','Hawking','Shkencë',18.00,14,'978-0-553-80202'],
            ['Bota e Balonave Blu','Carl','Sagan','Shkencë',17.00,16,'978-0-345-37928'],
            ['Kozmos','Carl','Sagan','Shkencë',19.00,12,'978-0-345-33135'],
            ['Zakonet Atomike','James','Clear','Biznes',22.00,40,'978-0-735-21129'],
            ['Si të Fitosh Miq','Dale','Carnegie','Biznes',18.00,35,'978-0-671-02703'],
            ['Mendoni dhe Bëhuni të Pasur','Napoleon','Hill','Biznes',16.00,30,'978-1-585-42433'],
            ['Inteligjenca Emocionale','Sigmund','Freud','Psikologji',14.00,27,'978-0-807-01429'],
            ['Historia e Artit','Paulo','Coelho','Arte',20.00,18,'978-0-714-83203'],
            ['Muzika dhe Emocionet','Carl','Sagan','Arte',15.00,14,'978-0-521-44358'],
            ['Piktura dhe Mendja','Carl','Jung','Arte',17.00,11,'978-0-691-11777'],
            ['Zotërinjtë e Fluturimeve','Haruki','Murakami','Roman',15.00,20,'978-0-385-72020'],
            ['Zemra e Errët','Albert','Camus','Roman',13.00,17,'978-0-679-72081'],
            ['Balada e Erës','Victor','Hugo','Poezi',11.00,24,'978-9928-08-121'],
            ['Fjalori i Shpirtit','Gabriel','García Márquez','Letërsi',16.00,15,'978-9928-08-122'],
            ['Historia e Botës','Yuval','Harari','Histori',21.00,26,'978-9928-08-123'],
            ['Zgjidhjet','Ernest','Hemingway','Roman',12.00,19,'978-9928-08-124'],
            ['Miqësia','Leo','Tolstoy','Letërsi',10.00,23,'978-9928-08-125'],
            ['Fjala e Fundit','Fyodor','Dostoevsky','Roman',14.00,16,'978-9928-08-126'],
            ['Epoka e Re','Franz','Kafka','Letërsi',11.00,18,'978-9928-08-127'],
            ['Vizioni','George','Orwell','Filozofi',13.00,14,'978-9928-08-128'],
            ['Njohja e Vetvetes','Friedrich','Nietzsche','Filozofi',11.00,19,'978-9928-08-129'],
            ['Ëndrrimi Kolektiv','Carl','Jung','Psikologji',13.00,21,'978-9928-08-130'],
            ['Kurioziteti Shkencor','Stephen','Hawking','Shkencë',15.00,17,'978-9928-08-131'],
            ['Marketing Dixhital','Dale','Carnegie','Biznes',19.00,28,'978-9928-08-132'],
            ['Lideri i Ri','Napoleon','Hill','Biznes',17.00,22,'978-9928-08-133'],
            ['Arte dhe Shpirti','Paulo','Coelho','Arte',14.00,20,'978-9928-08-134'],
            ['Unë dhe Bota','Faik','Konica','Letërsi',9.00,16,'978-9928-08-135'],
            ['Fjala e Dritës','Fan','Noli','Letërsi',8.00,20,'978-9928-08-136'],
            ['Mendime','Plato','','Filozofi',12.00,13,'978-9928-08-137'],
            ['Veprat e Zgjedhura','Naim','Frashëri','Poezi',10.00,22,'978-9928-08-138'],
            ['Dashuri nën Shi','Faik','Konica','Letërsi',8.50,18,'978-9928-08-139'],
            ['Kujtimet e Kohës','Gjergj','Fishta','Histori',12.00,10,'978-9928-08-140'],
            ['Filozofia e Jetës','Plato','','Filozofi',13.00,16,'978-9928-08-141'],
            ['Nata e Bariut','Teodor','Laço','Roman',9.50,20,'978-9928-08-142'],
            ['Agimi i Shkruar','Migjeni','','Poezi',9.00,18,'978-9928-08-143'],
            ['Njeriu i Lirë','Dritëro','Agolli','Roman',10.00,15,'978-9928-08-144'],
            ['Shpirt Shqiptar','Naim','Frashëri','Poezi',8.00,28,'978-9928-08-145'],
            ['Emblema e Dikurshme','Ismail','Kadare','Letërsi',15.00,11,'978-9928-08-146'],
            ['Muzgu i Perëndive','Friedrich','Nietzsche','Filozofi',12.00,14,'978-9928-08-147'],
            ['Vetmia dhe Shoqëria','Sigmund','Freud','Psikologji',13.00,19,'978-9928-08-148'],
            ['Programimi me Python','George','Orwell','Teknologji',30.00,20,'978-9928-08-149'],
            ['Bazat e Web Dev','Franz','Kafka','Teknologji',28.00,15,'978-9928-08-150'],
            ['Inteligjenca Artificiale','Stephen','Hawking','Teknologji',35.00,18,'978-9928-08-151'],
            ['Data Science me R','Carl','Sagan','Teknologji',32.00,12,'978-9928-08-152'],
            ['Siguria Kibernetike','Yuval','Harari','Teknologji',27.00,16,'978-9928-08-153'],
            ['Komunikimi Efektiv','Dale','Carnegie','Biznes',15.00,33,'978-9928-08-154'],
            ['Menaxhimi i Kohës','James','Clear','Biznes',18.00,29,'978-9928-08-155'],
            ['Investimi i Mençur','Napoleon','Hill','Biznes',20.00,25,'978-9928-08-156'],
            ['Psikologjia e Suksesit','Sigmund','Freud','Psikologji',16.00,22,'978-9928-08-157'],
            ['Arkitektura Moderne','Paulo','Coelho','Arte',22.00,13,'978-9928-08-158'],
            ['Revolucioni Industrial','Yuval','Harari','Histori',19.00,17,'978-9928-08-159'],
            ['Shkolla e Jetës','Ernest','Hemingway','Letërsi',11.00,24,'978-9928-08-160'],
        ];

        foreach ($books as $b) {
            $author = Author::where('emri', $b[1])->where('mbiemri', $b[2])->first();
            if (!$author) {
                $author = Author::create(['emri' => $b[1], 'mbiemri' => $b[2], 'biografia' => '']);
            }

            if (!isset($catIds[$b[3]])) {
                $cat = Category::firstOrCreate(['emri' => $b[3]], ['pershkrimi' => '']);
                $catIds[$b[3]] = $cat->id;
            }

            Book::firstOrCreate(
                ['isbn' => $b[6]],
                [
                    'titulli'     => $b[0],
                    'author_id'   => $author->id,
                    'category_id' => $catIds[$b[3]],
                    'cmimi'       => $b[4],
                    'sasia'       => $b[5],
                    'pershkrimi'  => 'Libër nga ' . trim($b[1] . ' ' . $b[2]) . '.',
                ]
            );
        }

        $this->command->info('✓ Libra: '      . Book::count());
        $this->command->info('✓ Autorë: '     . Author::count());
        $this->command->info('✓ Kategori: '   . Category::count());
    }
}
