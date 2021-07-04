<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
  <li class="nav-item has-treeview @yield('penjadwalan')">
    <a href="#" class="nav-link bg-success">
      <i class="nav-icon fa fa-calendar"></i>
      <p>
        Penjadwalan
        <i class="right fa fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview" style="display: @yield('displaypenjadwalan');">
      <li class="nav-item">
        <a href="#" class="nav-link @yield('jadwal_All')">
          <i class="fa fa-circle-o nav-icon"></i>
          <p>Jadwal All</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{url('/jadwal_AFLers')}}" class="nav-link @yield('jadwal_AFLers')">
          <i class="fa fa-circle-o nav-icon"></i>
          <p>Jadwal AFLers</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="./index2.html" class="nav-link">
          <i class="fa fa-circle-o nav-icon"></i>
          <p>Jadwal AFLees</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="./index3.html" class="nav-link">
          <i class="fa fa-circle-o nav-icon"></i>
          <p>Benefit</p>
        </a>
      </li>
    </ul>
  </li>
</ul>
{{-- TANDA --}}
<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
  <li class="nav-item has-treeview">
    <a href="#" class="nav-link bg-success active">
      <i class="nav-icon fa fa-money"></i>
      <p>
        Keuangan
        <i class="right fa fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
      <li class="nav-item">
        <a href="./index.html" class="nav-link">
          <i class="fa fa-circle-o nav-icon"></i>
          <p>Tagihan AFLees</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="./index2.html" class="nav-link">
          <i class="fa fa-circle-o nav-icon"></i>
          <p>Fee AFLers</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="./index3.html" class="nav-link active">
          <i class="fa fa-circle-o nav-icon"></i>
          <p>Pendapatan</p>
        </a>
      </li>
    </ul>
  </li>
</ul>
