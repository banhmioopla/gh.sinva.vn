<div class="shadow button-list card-box">
    <?php if(isYourPermission('Apartment', 'showBySearch',$this->permission_set)):?>
            <h4 class="text-danger text-center" >Tìm kiếm phòng đang trống</h4>
            <span id="listPrice">
                <span class="form-group row">
                    <span class="col-md-6 offset-md-3 col-12 offset-0">
                        <select name="roomPrice" id="roomPrice" class="form-control">
                            <?php echo $libRoom->cbAvailableRoomPrice($this->input->get('roomPrice'))
                            ?>
                        </select>
                    </span>

                </span>

            </span>



    <?php endif; ?>

</div>

<script>
    commands.push(function(){
        $('#roomPrice').on('change', function(){
            window.location = '/admin/apartment/show-by-search?roomPrice=' + $(this)
                .val();
        })
    });
</script>