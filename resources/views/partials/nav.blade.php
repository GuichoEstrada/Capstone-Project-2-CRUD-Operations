<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/books"><i class="fas fa-book-reader"><strong> Turn The Page</strong></i></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end text-center" id="navbarSupportedContent">
    <ul class="navbar-nav">
      @if(Auth::user() && Auth::user()->role_id == 2)
      <li class="nav-item" >
        <a class="nav-link" href="/books"><i class="fas fa-home"></i> Home</span></a>
      </li>
      <li class="nav-item" >
        <a class="nav-link" href="/customer"><i class="fas fa-retweet"></i> Request/Return</span></a>
      </li>
      @endif
      @if(Auth::user() && Auth::user()->role_id == 1)
      <li class="nav-item" >
        <a class="nav-link" href="/books"><i class="fas fa-home"></i> Home</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/books/add_book" id="addBookBtn" data-toggle="modal" data-target="#addModal"><i class="far fa-plus-square"></i> Add Books</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/categories"><i class="fas fa-clipboard-list"></i> Categories</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/admin_page"><i class="fas fa-hand-holding"></i> Requests</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin/return_books"><i class="fas fa-undo"></i> Return Books</a>
      </li>
      <script type="text/javascript">
        addBookBtn.addEventListener('click', function(){
          fetch('/add/add_book')
          .then( function(res) {
            return res.text();
          })
          .then( function(data){
            addBookBody.innerHTML = data
          })
        })
      </script>
      @endif
      <li class="nav-item">
        <form method="post" action="/logout">
          <button class="btn btn-secondary ml-5">
          {{csrf_field()}}
          <i class="fas fa-sign-out-alt"></i> Logout</a>
          </button>
        </form>
      </li>
    </ul>
  </div>
</nav>

{{-- ADD BOOK MODAL --}}
<div class="modal" tabindex="-1" id="addModal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBookTitle"><strong>Add a Book</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="addBookBody">
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
{{-- END OF ADD BOOK MODAL --}}