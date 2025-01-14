<form class="d-flex ms-4 p-4 mb-0" onsubmit="event.preventDefault(); filterTable();">
    <div class="input-group">
        <input id="{{ $id }}" class="form-control mr-2" type="search" placeholder="{{ $placeholder }}" aria-label="Search">
        <button type="submit" class="btn btn-success d-flex align-items-center" aria-label="Search">
            <i class="fa fa-search"></i>
        </button>
    </div>
</form>
