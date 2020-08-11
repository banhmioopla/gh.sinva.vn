<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu">
                <?php foreach($menu as $m): ?>
                    <li class="has-submenu">
                        <a href="<?= $m['url'] ?>">
                            <i class="icon-speedometer"></i><?= $m['name'] ?>
                        </a>
                        <?php if(!empty($m['submenu'])): ?>
                            <ul class="submenu">
                            <?php foreach($m['submenu'] as $sub): ?>
                                <li>
                                    <a href="<?= $sub['url'] ?>"><?= $sub['name'] ?></a>
                                </li>
                            <?php endforeach;?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!-- End navigation menu -->
        </div>
        <!-- end #navigation -->
    </div>
    <!-- end container -->
</div>