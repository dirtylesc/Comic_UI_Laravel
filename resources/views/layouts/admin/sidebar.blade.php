<style>
    .side-bar {
        background-color: var(--bg_sidebar);
    }

    .dashboard_label {
        color: var(--c_label);
        font-size: 1.3rem;
    }

    .currentSpan {
        min-width: max-content;
    }
</style>
<div class="side-bar col-md-2_5 position-absolute h-100">
    <div class="app-header border-bottom">
        <div class="app-sidebar-logo mb-4 mx-4 pt-4 flex-shrink-0">
            <a href="{{ route('reader.index') }}" class="d-flex justify-content-center" style="color: black">
                <h3 style="margin-bottom: 0;" class="fw600 lc1_5">Dirtylesc Company</h3>
            </a>
        </div>
    </div>
    <div class="app-wrapper m-3">
        <label for="" class="dashboard_label my-2 dt">
            <span class="menu-icon">
                <span class="svg-icon svg-icon-5">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        style="transform: rotate(90deg)" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.4 11H3C2.4 11 2 11.4 2 12C2 12.6 2.4 13 3 13H14.4V11Z" fill="currentColor"></path>
                        <path opacity="0.3" d="M14.4 20V4L21.7 11.3C22.1 11.7 22.1 12.3 21.7 12.7L14.4 20Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
            </span>
            DashBoard</label>
        <div class="menu-sub flex-column list-unstyled m-0 p-0">
            @if (isSuperAdmin())
                <div class="menu-item py-2 my-2 flex-column @if ($currentRoute === 'users') current @endif">
                    <a href="{{ route('admin.index') }}" class="px-1 d-flex align-items-center text-decoration-none">
                        <span class="bullet bullet-dot mx-3 "></span>
                        <span class="currentSpan">Users</span>
                    </a>
                </div>
            @endif
            <div class="menu-item py-2 my-2 @if ($currentRoute === 'comics') current @endif">
                <a href="{{ route('admin.comics.index') }}" class="px-1 d-flex align-items-center text-decoration-none">
                    <span class="bullet bullet-dot mx-3 "></span>
                    <span class="currentSpan">Comics</span>
                </a>
            </div>
            <div class="menu-item py-2 my-2 flex-column @if ($currentRoute === 'teams') current @endif">
                <a href="{{ route('admin.teams.index') }}" class="px-1 d-flex align-items-center text-decoration-none">
                    <span class="bullet bullet-dot mx-3 "></span>
                    <span class="currentSpan">Team Translator</span>
                </a>
            </div>
            <div class="menu-item py-2 my-2 flex-column @if ($currentRoute === 'ranking') current @endif">
                <a href="{{ route('admin.ranking.index') }}"
                    class="px-1 d-flex align-items-center text-decoration-none">
                    <span class="bullet bullet-dot mx-3 "></span>
                    <span class="currentSpan">Ranking</span>
                </a>
            </div>
        </div>
    </div>
</div>
