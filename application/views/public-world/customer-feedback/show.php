<div class="wrapper">
    <div class="container">
        <!-- end page title end breadcrumb -->
        <form action="/public/customer-feedback/create" method="post">
            <div class="row">
                <div class="col-md-12 text-center ">
                    <div class="card-box">
                        <img class="img-fluid" src="https://image.freepik.com/free-vector/feedback-illustration_126608-689.jpg" alt="">
                    </div>

                </div>
                <div class="col-12 mt-2">
                    <div class="card-box">
                        <h2 class="text-danger text-center font-weight-bold"><?= $page_title ?></h2>
                        <div class="row">
                            <input type="hidden" name="user_id" value="<?= $this->input->get('account-id') ?>">
                            <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-2 col-form-label text-right">Email *</label>
                                    <div class="col-10">
                                        <input type="email" name="email" class="form-control" placeholder="abc@gmailcom" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label text-right">Họ và tên *</label>
                                    <div class="col-10">
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label text-right">Số điện thoại *</label>
                                    <div class="col-10">
                                        <input type="text" name="phone" class="form-control" required>
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group row">
                                    <label class="col-10 offset-2 font-weight-bold col-form-label">Anh/chị cảm thấy trang phục của nhân viên Sinvahome như thế nào? *</label>
                                    <div class="col-9 offset-3">
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="checkbox-1" type="radio" required name="suit" value="Lịch sự">
                                            <label for="checkbox-1">
                                                Lịch sự
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="checkbox-2" type="radio" required name="suit" value="Rất chuyên nghiệp">
                                            <label for="checkbox-2">
                                                Rất chuyên nghiệp
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="checkbox-3" type="radio" required name="suit" value="Thiếu chuyên nghiệp">
                                            <label for="checkbox-3">
                                                Thiếu chuyên nghiệp
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="checkbox-4" type="radio" required name="suit" value="Xuề xoà">
                                            <label for="checkbox-4">
                                                Xuề xoà
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-10 offset-2 font-weight-bold col-form-label">Anh/chị cảm thấy thái độ tiếp đón của nhân viên Sinvahome như thế nào?</label>
                                    <div class="col-9 offset-3">
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="attitude-1" type="radio" required name="attitude" value="Niềm nở, nhiệt tình">
                                            <label for="attitude-1">
                                                Niềm nở, nhiệt tình
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="attitude-2" type="radio" required name="attitude" value="Hơn cả mong đợi">
                                            <label for="attitude-2">
                                                Hơn cả mong đợi
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="attitude-3" type="radio" required name="attitude" value="Bình thường">
                                            <label for="attitude-3">
                                                Bình thường
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="attitude-4" type="radio" required name="attitude" value="Hời hợt">
                                            <label for="attitude-4">
                                                Hời hợt
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-10 offset-2 font-weight-bold col-form-label">Tinh thần giải quyết vấn đề cho anh/chị của nhân viên Sinvahome như thế nào? *</label>
                                    <div class="col-9 offset-3">
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="problemsolving-1" type="radio" required name="problem_solving" value="Luôn cố gắng tìm giải pháp để giúp đỡ tôi" >
                                            <label for="problemsolving-1">
                                                Luôn cố gắng tìm giải pháp để giúp đỡ tôi
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="problemsolving-2" type="radio" required name="problem_solving" value="Luôn sẵn sàng hỗ trợ tôi">
                                            <label for="problemsolving-2">
                                                Luôn sẵn sàng hỗ trợ tôi
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="problemsolving-3" type="radio" required name="problem_solving" value="Bình thường">
                                            <label for="problemsolving-3">
                                                Bình thường
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="problemsolving-4" type="radio" required name="problem_solving" value="Luôn lảng tránh những yêu cầu của tôi">
                                            <label for="problemsolving-4">
                                                Luôn lảng tránh những yêu cầu của tôi
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-10 offset-2 font-weight-bold col-form-label">Anh/chị cảm thấy thế nào về cách nhân viên Sinvahome giải quyết vấn đề cho anh/chị? *</label>
                                    <div class="col-9 offset-3">
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="solution-1" type="radio" name="solution" value="Rất vui vì mọi vấn đề được giải quyết">
                                            <label for="solution-1">
                                                Rất vui vì mọi vấn đề được giải quyết
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="solution-2" type="radio" name="solution" value="Khó có thể được đáp ứng ở toà nhà này">
                                            <label for="solution-2">
                                                Khó có thể được đáp ứng ở toà nhà này
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="solution-3" type="radio" name="solution" value="Không được giải quyết thoả đáng">
                                            <label for="solution-3">
                                                Không được giải quyết thoả đáng
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="solution-4" type="radio" name="solution" value="Không làm hết sức">
                                            <label for="solution-4">
                                                Không làm hết sức
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-10 offset-2 font-weight-bold col-form-label">Anh/chị cảm thấy thế nào khi được nhân viên Sinvahome hỗ trợ? *</label>
                                    <div class="col-9 offset-3">
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="feel_to_be_supported-1" type="radio" name="feel_to_be_supported" value="Thoải mái, đáng tin">
                                            <label for="feel_to_be_supported-1">
                                                Thoải mái, đáng tin
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="feel_to_be_supported-2" type="radio" name="feel_to_be_supported" value="Được thấu hiểu">
                                            <label for="feel_to_be_supported-2">
                                                Được thấu hiểu
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="feel_to_be_supported-3" type="radio" name="feel_to_be_supported" value="Không có gì đặc biệt">
                                            <label for="feel_to_be_supported-3">
                                                Không có gì đặc biệt
                                            </label>
                                        </div>
                                        <div class="radio radio-danger checkbox-circle">
                                            <input id="feel_to_be_supported-4" type="radio" name="feel_to_be_supported" value="Không tin tưởng">
                                            <label for="feel_to_be_supported-4">
                                                Không tin tưởng
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-10 offset-2 font-weight-bold col-form-label">Nhân viên Sinvahome hiểu nhu cầu của anh/chị ở mức độ nào? (chấm theo thang điểm 10) *</label>
                                    <div class="col-9 offset-3">
                                        <input type="number" class="form-control" name="understanding_score" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-10 offset-2 font-weight-bold col-form-label">Anh/chị đánh giá căn phòng này được bao nhiêu điểm?(chấm theo thang điểm 10) *</label>
                                    <div class="col-9 offset-3">
                                        <input type="number" class="form-control" name="room_score" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-10 offset-2 font-weight-bold col-form-label">Theo Anh/chị, căn phòng này cần có thêm yếu tố gì để hoàn hảo? *</label>
                                    <div class="col-9 offset-3">
                                        <textarea class="form-control" name="room_requirement" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-10 offset-2 font-weight-bold col-form-label">Anh/chị kì vọng thêm điều gì về nhân viên của Sinvahome?</label>
                                    <div class="col-9 offset-3">
                                        <textarea class="form-control" name="consultant_requirement" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-10 offset-2 font-weight-bold col-form-label">Anh/chị có đánh giá gì thêm không?</label>
                                    <div class="col-9 offset-3">
                                        <textarea class="form-control" name="additional_feedback"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <button type="submit" class="btn-danger btn col-md-2 offset-md-5">Gửi</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div> <!-- end container -->
</div>