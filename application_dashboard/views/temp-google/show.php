<div class="wrapper">
    <div class="sk-wandering-cubes" style="display:none" id="loader">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
    </div>
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">test</a></li>
                            <li class="breadcrumb-item"><a href="#">Extra Pages</a></li>
                            <li class="breadcrumb-item active">Starter</li>
                        </ol>
                    </div>
                    <h3>Google drive</h3>
                </div>
            </div>
            <?php $this->load->view('components/list-navigation'); ?>
            <div class="col-md-12">
                <div class="card-box">
                    <?php foreach($list_linkdrive['googledrive'] as $item => $container):?>
                        <a href="<?= $container['link'] ?>" target="blank">
                            <button type="button" class="btn btn-custom btn-rounded waves-light m-2 waves-effect">
                                <?= $container['quan'] ?>
                            </button>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- <div class="col-md-12"></div> put component here -->
            <div class="col-md-12 mt-2" style="height: 550px">
                <div class="card-box h-100">
                    <div  class="gmaps h-100">
                        <!-- <iframe width="100%" height="100%" src="https://docs.google.com/spreadsheets/d/1x39nUW-jwdFzVx77cwMI-epkNC34z87trzDbKIoRdU8/edit?fbclid=IwAR1WbNfUEjGJzitBEYSe0Xo8UGMjItvXYSfGrR84s7w-e11ptXBQdbTy5os#gid=2058118353" frameborder="0"></iframe> -->
                        <iframe  width="100%" height="100%" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vS7uJ8FabrwE0lWBsJeCFcxMTQlKa8xx53pqlDn_eDSsvGxODpeHkTtECZysYETFd5FijQChrLVOrcE/pubhtml?widget=true&amp;headers=false"></iframe>
            <!-- <div id="calendar"></div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>