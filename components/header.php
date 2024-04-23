<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
       <div class="message message-info">
         <div class="message-content">
           <span>
           <i class="fa-solid fa-circle-exclamation fa-2xl" style="color: #2F86EB;"></i> '.$msg.'
           </span>
           <i class="fa-solid fa-circle-xmark fa-2xs" style="color: #ff355b;" onclick="removeMessage(this.parentElement.parentElement);"></i>
         </div>
         <div class="progress-bar"></div>
       </div>';
    }
}

if (isset($message_success)) {
    foreach ($message_success as $msg_success) {
        echo '
       <div class="message message-success">
         <div class="message-content">
           <span>
               <i class="fa-solid fa-circle-check fa-2xl" style="color: #47d764;"></i> '.$msg_success.'
           </span>
           <i class="fa-solid fa-circle-xmark fa-2xs" style="color: #ff355b;" onclick="removeMessage(this.parentElement.parentElement);"></i>
         </div>
         <div class="progress-bar"></div>
       </div>';
    }
}

if (isset($message_error)) {
    foreach ($message_error as $msg_error) {
        echo '
       <div class="message message-error">
         <div class="message-content">
           <span>
           <i class="fa-solid fa-circle-exclamation fa-2xl" style="color: #ff355b;"></i> '.$msg_error.'
           </span>
           <i class="fa-solid fa-circle-xmark fa-2xs" style="color: #ff355b;" onclick="removeMessage(this.parentElement.parentElement);"></i>
         </div>
         <div class="progress-bar"></div>
       </div>';
    }
}




?>


<nav class="navbar navbar-expand-lg bg-body-tertiary  container">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Notes App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="create_note.php">Create Note</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>



<script>
        function removeMessage(messageElement) {
        messageElement.style.opacity = 0;
        setTimeout(function () {
        messageElement.remove();
        }, 500);
        }

        setTimeout(function () {
        var messageElement = document.querySelector('.message');
        if (messageElement) {
            removeMessage(messageElement);
        }
        }, 5000);

        </script>