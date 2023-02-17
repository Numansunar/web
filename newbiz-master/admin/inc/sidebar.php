<div id="wrapper">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item <?php echo $sayfa == 'Ana Sayfa' ? 'active' : '' ?>">
            <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Ana Sayfa</span>
            </a>
        </li>
         <li class="nav-item <?php echo $sayfa == 'Hakkımızda' ? 'active' : '' ?>">
            <a class="nav-link" href="hakkimizda.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Hakkımızda</span>
            </a>
        </li>

        <li class="nav-item <?php echo $sayfa == 'Katalog' ? 'active' : '' ?>">
            <a class="nav-link" href="katalog.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Kataloglar</span></a>
        </li>
        <li class="nav-item <?php echo $sayfa == 'İletişim' ? 'active' : '' ?>">
            <a class="nav-link" href="iletisim.php">
                <i class="fas fa-fw fa-table"></i>
                <span>İletişim</span></a>
        </li>
		<li class="nav-item <?php echo $sayfa == 'Portfolyo' ? 'active' : '' ?>">
            <a class="nav-link" href="portfolyo.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Portfolyo</span></a>
        </li>
		<li class="nav-item <?php echo $sayfa == 'Ortaklar' ? 'active' : '' ?>">
            <a class="nav-link" href="ortaklar.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Ortaklar</span></a>
        </li>
		<li class="nav-item <?php echo $sayfa == 'Takım' ? 'active' : '' ?>">
            <a class="nav-link" href="takim.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Takım</span></a>
        </li>
         <li class="nav-item <?php echo $sayfa == 'Mağaza' ? 'active' : '' ?>">
            <a class="nav-link" href="magaza.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Mağaza</span></a>
        </li>
         <li class="nav-item <?php echo $sayfa == 'Mağaza Saat' ? 'active' : '' ?>">
            <a class="nav-link" href="magazaSaat.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Mağaza Saat</span></a>
        </li>
            <li class="nav-item <?php echo $sayfa == 'Kullanıcılar' ? 'active' : '' ?>">
            <a class="nav-link" href="kullanicilar.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Kullanıcılar</span></a>
        </li>
    </ul>