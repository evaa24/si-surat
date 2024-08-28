@if(session()->exists('role') and isset(session('role')['is_admin']))
    {{-- Role Admin --}}
    @include('template.sidebar.admin')
@endif

@if(session()->exists('role') and isset(session('role')['is_wk']))
    {{-- Role Wakil Ketua --}}
    @include('template.sidebar.wakil')
@endif

@if(session()->exists('role') and isset(session('role')['is_secretary']))
    {{-- Role Sekretaris --}}
    @include('template.sidebar.sekretaris')
@endif

@if(session()->exists('role') and isset(session('role')['is_staff']))
    {{-- Role Karyawan--}}
    @include('template.sidebar.staff')
@endif
