                    <div class="topbar">
                        <nav class="navbar-custom">
                            <!-- Search input -->
                            <div class="search-wrap" id="search-wrap">
                                <div class="search-bar">
                                    <input class="search-input" type="search" placeholder="Search" />
                                    <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <ul class="list-inline float-right mb-0">
                                <!-- Fullscreen -->
                                <li class="list-inline-item dropdown notification-list hidden-xs-down">
                                    <a class="nav-link waves-effect" href="#" id="btn-fullscreen">
                                        <i class="mdi mdi-fullscreen noti-icon"></i>
                                    </a>
                                </li>
                                <!-- Logout-->
                                <li class="list-inline-item dropdown notification-list pr-4 pl-2">
                                        <a href="index.php?pages=logout"  class="btn btn-primary waves-effect waves-light">Logout</a>
                                </li>
                            </ul>

                            <!-- Page title -->
                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="ion-navicon"></i>
                                    </button>
                                </li>
                                <li class="hide-phone list-inline-item app-search">
                                    <?php
                                    $pageTitle = 'Dashboard';

                                    if (isset($_GET['pages'])) {
                                        $map = [
                                            'dashboard' => 'Dashboard',
                                            'produk' => 'Produk',
                                            'tambah-produk' => 'Tambah Produk',
                                            'ubah-produk' => 'Ubah Produk',
                                            'tambah-kategori' => 'Kategori',
                                            'hapus-kategori' => 'Kategori',
                                            'pelanggan' => 'Pelanggan',
                                            'order' => 'Order',
                                            'detail-order' => 'Detail Order',
                                            'pembayaran' => 'Pembayaran',
                                            'logout' => 'Logout'
                                        ];

                                        $pageTitle = $map[$_GET['pages']] ?? ucwords(str_replace('-', ' ', $_GET['pages']));
                                    }
                                    ?>
                                    <h3 class="page-title mb-0"><?= $pageTitle ?></h3>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </nav>

                    </div>