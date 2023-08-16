<div class="col-7 align-self-center">
    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">{{ $title }}</h3>
    <div class="d-flex align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0 p-0">
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb[0] }}">{{ $breadcrumb[1] }}</a>
                    </li>
                @endforeach
            </ol>
        </nav>
    </div>
</div>