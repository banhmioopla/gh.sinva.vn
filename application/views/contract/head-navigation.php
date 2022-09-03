<div class="button-list mb-2">
    <a href="/admin/list-contract"><button type="button" class="btn btn-pink" >Mặc định</button></a>
    <a href="/admin/list-contract?partialGroup=consultant&<?= $this->current_query ?>"><button type="button" class="btn btn-pink" >Thành viên chốt</button></a>
    <a href="/admin/list-contract?partialGroup=timeLine" ><button type="button" disabled="" class="btn btn-pink" >Time line</button></a>
    <a href="/admin/list-contract?partialGroup=Chart"><button type="button" class="btn btn-pink" >Biểu đồ</button></a>
</div>