<div class="row justify-content-center">

    @if(hasRoutePermission('simple_cms.acl.backend.user.index'))
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $countUsers }}</h3>
                    <p>USERS</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('simple_cms.acl.backend.user.index') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    @endif

    @if(hasRoutePermission('simple_cms.blog.backend.post.index'))
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $countPosts }}</h3>
                    <p>POSTS</p>
                </div>
                <div class="icon">
                    <i class="far fa-newspaper"></i>
                </div>
                <a href="{{ route('simple_cms.blog.backend.post.index') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    @endif

    @if(hasRoutePermission('simple_cms.blog.backend.page.index'))
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $countPages }}</h3>
                    <p>PAGES</p>
                </div>
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <a href="{{ route('simple_cms.blog.backend.page.index') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    @endif
</div>
