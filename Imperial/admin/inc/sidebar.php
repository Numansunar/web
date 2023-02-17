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
         <li class="nav-item <?php echo $sayfa == 'Referanslar' ? 'active' : '' ?>">
            <a class="nav-link" href="referanslar.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Referanslar</span></a>
        </li>
        <li class="nav-item <?php echo $sayfa == 'Servisler' ? 'active' : '' ?>">
            <a class="nav-link" href="servisler.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Servisler</span></a>
        </li>
        <li class="nav-item <?php echo $sayfa == 'İletişim' ? 'active' : '' ?>">
            <a class="nav-link" href="iletisim.php">
                <i class="fas fa-fw fa-table"></i>
                <span>İletişim</span></a>
        </li>
         <li class="nav-item <?php echo $sayfa == 'Adres' ? 'active' : '' ?>">
            <a class="nav-link" href="adres.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Adres</span></a>
        </li>
         <li class="nav-item <?php echo $sayfa == 'Portfolyo' ? 'active' : '' ?>">
            <a class="nav-link" href="portfolyo.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Portfolyo</span></a>
        </li>		
         <li class="nav-item <?php echo $sayfa == 'Takım' ? 'active' : '' ?>">
            <a class="nav-link" href="takim.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Takım</span></a>
        </li>
            <li class="nav-item <?php echo $sayfa == 'Kullanıcılar' ? 'active' : '' ?>">
            <a class="nav-link" href="kullanicilar.php">
                <i class="fas fa-fw fa-table"></i>
                <span>Kullanıcılar</span></a>
        </li>
    </ul>