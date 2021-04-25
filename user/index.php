<!-- begin:: head -->
<?php include_once 'atribut/head.php'; ?>
<!-- end:: head -->

<div id="app">
    <!-- begin:: sidebar -->
    <?php include_once 'atribut/sidebar.php'; ?>
    <!-- end:: sidebar -->
    <div id="main">
        <!-- begin:: navbar -->
        <?php include_once 'atribut/navbar.php'; ?>
        <!-- end:: navbar -->
        <div class="main-content container-fluid">
            <div class="page-title">
                <h3>Dashboard</h3>
                <p class="text-subtitle text-muted">Sistem Pendukung Keputusan Penentuan Tanaman Pangan Dengan Algoritma ELECTRE dan VIKOR</p>
            </div>
            <section class="section">
                <div class="row mb-2">
                <div class="col-4 col-md-6">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h3 class="card-title">METODE ELECTRE</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                            ELECTRE merupakan salah satu metode pengambilan keputusan multikriteria berdasarkan pada konsep outranking dengan menggunakan perbandingan berpasangan dari altematif-alternatif berdasarkan setiap kriteria yang sesuai. Metode ELECTRE digunakan pada kondisi dimana alternatif yang kurang sesuai dengan kriteria dieliminasi dan alternatif yang sesuai dapat dihasilkan. Dengan kata lain, ELECTRE digunakan untuk kasus-kasus dengan banyak alternatif namun hanya sedikit kriteria yang dilibatkan.
                            </p>
                            <p class="card-text">
                            Langkah-langkah yang dilakukan dalam penyelesaian masalah menggunakan metode ELECTRE adalah sebagai berikut:
                            <ul style="padding: 15px">
                                <li>Normalisasi Matriks Keputusan</li>
                                <li>Pembobotan Pada Matriks Yang Telah Dinormalisasi</li>
                                <li>Menentukan himpunan concordance dan discordance index</li>
                                <li>Menghitung matriks concordance dan discordance</li>
                                <li>Menentukan matriks dominan concordance dan discordance</li>
                                <li>Menentukan aggregate dominance matrix</li>
                                <li>Eliminasi alternatif yang less favourable</li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-4 col-md-6">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <h3 class="card-title">METODE VIKOR</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                            VIKOR merupakan suatu metode Multi Criteria Decision Making (MCDM) yang pertama kali dikembangkan dan diajukan oleh Opricovic & Tzeng pada tahun 1998. VIKOR secara harafiah memiliki arti optimatisasi beberapa kriteria ke dalam peringkat kompromi. VIKOR digunakan dalam menentukan daftar solusi peringkat, solusi kompromi, serta rentang stabilitas bobot yang dijadikan dasar bagi stabilitas solusi kompromi yang diperoleh dari bobot awal (bobot inisialisasi). 
                            </p>
                            <p class="card-text">
                            Langkah-langkah yang dilakukan dalam penyelesaian masalah menggunakan metode VIKOR adalah sebagai berikut:
                            <ul style="padding: 25px">
                                <li>Membuat Matriks Keputusan</li>
                                <li>Menentukan Bobot Kriteria</li>
                                <li>Matriks Normalisasi</li>
                                <li>Normalisasi Bobot</li>
                                <li>Menghitung Utility Measures (S) dan Regret Measures (R)</li>
                                <li>Menghitung Indeks VIKOR</li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </div>
            </div>  
            </section>
        </div>

        <!-- begin:: footer -->
        <?php include_once 'atribut/footer.php' ?>
        <!-- end:: footer -->
    </div>
</div>

<!-- begin:: foot -->
<?php include_once 'atribut/foot.php'; ?>
<!-- end:: foot -->