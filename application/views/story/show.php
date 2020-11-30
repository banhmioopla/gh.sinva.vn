<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-1 d-none">
                <div id="stories" class="storiesWrapper"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1 col-12">
                <?php $this->load->view('components/list-navigation'); ?>
            </div>
        </div>


        <div class="row">
            <div class="col-md-10 offset-md-1 col-12">
                <div>

                    <form action="/admin/create-story" method="post" class="">
                        <div>
                            <button type="submit" class="btn btn-danger">
                                <h5>Đăng Câu
                                    Chuyện Kinh Doanh Của Bạn</h5></button>
                        </div>

                        <div class="form-group row mt-2">
                            <div class="col-10">
                                <input class="form-control" name="title"
                                       placeholder="tiêu đề..."
                                          required>
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <div class="col-10">
                                <textarea class="form-control" placeholder="nội dung"
                                          name="content"
                                          required
                                          rows="5"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="timeline mt-md-2">

                    <?php $alt = ''; foreach ($list_story as $item):

                        if($alt == 'alt')
                            $alt = '';
                        else {
                            $alt = 'alt';
                        }

                        ?>
                        <article class="timeline-item <?= $alt ?>">
                            <div class="timeline-desk">
                                <div class="panel">
                                    <div class="timeline-box">
                                        <span class="arrow-alt"></span>
                                        <span class="timeline-icon bg-danger"><i
                                                    class="mdi mdi-adjust"></i></span>
                                        <h4 class="text-danger text-left"><?= $item['title']?></h4>
                                        <p class="timeline-date text-left
                                    text-muted"><small><?= date('d/m/Y H:i', $item['time_insert'])
                                                ?> - <?= $libUser->getNameByAccountid($item['user_create_id']) ?></small></p>
                                        <p class="text-left"><?= $item['content'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                    <article class="timeline-item alt">
                        <div class="timeline-desk">
                            <div class="panel">
                                <div class="timeline-box ">
                                    <span class="arrow-alt"></span>
                                    <span class="timeline-icon bg-danger"><i class="mdi mdi-adjust"></i></span>
                                    <h4 class="text-danger text-left">Xin chào các bạn, đây là
                                        story đầu tiên</h4>
                                    <p class="timeline-date text-left
                                    text-muted"><small>30/04/1975 11:30 am</small></p>
                                    <p class="text-left">Mỗi khi tôi tới sinva, công ty cứ như tăng thêm
                                        một người.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>

                </div>
            </div>
        </div>
    </div>


</div>

<script>
    commands.push(function(){
        var timestamp = function() {
            var timeIndex = 0;
            var shifts = [35, 60, 60 * 3, 60 * 60 * 2, 60 * 60 * 25, 60 * 60 * 24 * 4, 60 * 60 * 24 * 10];

            var now = new Date();
            var shift = shifts[timeIndex++] || 0;
            var date = new Date(now - shift * 1000);

            return date.getTime() / 1000;
        };

        var changeSkin = function(skin) {
            location.href = location.href.split('#')[0].split('?')[0] + '?skin=' + skin;
        };

        var getCurrentSkin = function() {
            var header = document.getElementById('header');
            var skin = location.href.split('skin=')[1];

            if (!skin) {
                skin = 'Snapgram';
            }

            if (skin.indexOf('#') !== -1) {
                skin = skin.split('#')[0];
            }

            var skins = {
                Snapgram: {
                    avatars: true,
                    list: false,
                    autoFullScreen: false,
                    cubeEffect: true,
                    paginationArrows: false
                },

                VemDeZAP: {
                    avatars: false,
                    list: true,
                    autoFullScreen: false,
                    cubeEffect: false,
                    paginationArrows: true
                },

                FaceSnap: {
                    avatars: true,
                    list: false,
                    autoFullScreen: true,
                    cubeEffect: false,
                    paginationArrows: true
                },

                Snapssenger: {
                    avatars: false,
                    list: false,
                    autoFullScreen: false,
                    cubeEffect: false,
                    paginationArrows: false
                }
            };

            var el = document.querySelectorAll('#skin option');
            var total = el.length;
            for (var i = 0; i < total; i++) {
                var what = skin == el[i].value ? true : false;

                if (what) {
                    el[i].setAttribute('selected', 'selected');

                    header.innerHTML = skin;
                    header.className = skin;
                } else {
                    el[i].removeAttribute('selected');
                }
            }

            return {
                name: skin,
                params: skins[skin]
            };
        };


        var currentSkin = getCurrentSkin();
        var stories = new Zuck('stories', {
            backNative: true,
            previousTap: true,
            skin: currentSkin['name'],
            autoFullScreen: currentSkin['params']['autoFullScreen'],
            avatars: currentSkin['params']['avatars'],
            paginationArrows: currentSkin['params']['paginationArrows'],
            list: currentSkin['params']['list'],
            cubeEffect: currentSkin['params']['cubeEffect'],
            localStorage: true,
            stories: [
                Zuck.buildTimelineItem(
                    "ramon",
                    "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/users/1.jpg",
                    "Ramonsss",
                    "https://ramon.codes",
                    timestamp(),
                    [
                        ["ramon-1", "photo", 3, "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/1.jpg", "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/1.jpg", '', false, false, timestamp()],
                        ["ramon-2", "video", 0, "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/2.mp4", "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/2.jpg", '', false, false, timestamp()],
                        ["ramon-3", "photo", 3, "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/3.png", "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/3.png", 'https://ramon.codes', 'Visit my Portfolio', false, timestamp()]
                    ]
                ),
                Zuck.buildTimelineItem(
                    "gorillaz",
                    "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/users/2.jpg",
                    "Gorillaz",
                    "",
                    timestamp(),
                    [
                        ["gorillaz-1", "video", 0, "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/4.mp4", "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/4.jpg", '', false, false, timestamp()],
                        ["gorillaz-2", "photo", 3, "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/5.jpg", "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/5.jpg", '', false, false, timestamp()],
                    ]
                ),
                Zuck.buildTimelineItem(
                    "ladygaga",
                    "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/users/3.jpg",
                    "Lady Gaga",
                    "",
                    timestamp(),
                    [
                        ["ladygaga-1", "photo", 5, "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/6.jpg", "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/6.jpg", '', false, false, timestamp()],
                        ["ladygaga-2", "photo", 3, "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/7.jpg", "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/7.jpg", 'http://ladygaga.com', false, false, timestamp()],
                    ]
                ),
                Zuck.buildTimelineItem(
                    "starboy",
                    "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/users/4.jpg",
                    "The Weeknd",
                    "",
                    timestamp(),
                    [
                        ["starboy-1", "photo", 5, "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/8.jpg", "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/8.jpg", '', false, false, timestamp()]
                    ]
                ),
                Zuck.buildTimelineItem(
                    "riversquomo",
                    "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/users/5.jpg",
                    "Rivers Cuomo",
                    "",
                    timestamp(),
                    [
                        ["riverscuomo", "photo", 10, "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/9.jpg", "https://raw.githubusercontent.com/ramon82/assets/master/zuck.js/stories/9.jpg", '', false, false, timestamp()]
                    ]
                )
            ]
        });
    });

</script>

