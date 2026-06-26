<div class="tab-pane fade{{ ($active ?? false) ? ' show active' : '' }}" id="{{ $id }}" role="tabpanel" tabindex="0">
  <nav class="app-navbar" data-simplebar>
    <ul class="side-menubar">
      @include($itemsView)
    </ul>
  </nav>
</div>
