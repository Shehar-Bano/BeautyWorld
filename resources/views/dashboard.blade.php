@include('view.head')

@include('view.topbar')
@include('view.sidebar')
<div class="page-wrapper">

    <div class="container-fluid">
      @include('view.content')
      @include('view.sale')
    </div>

</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
</div>

@include('view.script')
