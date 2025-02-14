<?php
session_start();

require_once "db_connect.php";
require_once "userSession.php";
require_once "file_upload.php";

function cleanInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($connect, $sql);

    if (!$result) {
        echo "Query Error: " . mysqli_error($connect);
        exit();
    }

    $row = mysqli_fetch_assoc($result);
} else {
    echo "User ID not provided.";
    exit();
}


$backBtn = "index.php";

if (isset($_SESSION["adm"])) {
    $backBtn = "dashboard.php";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= include_once "brand.php"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
.gradient-custom {
/* fallback for old browsers */
background: #fccb90;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to bottom right, rgba(252, 203, 144, 1), rgba(213, 126, 235, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to bottom right, rgba(252, 203, 144, 1), rgba(213, 126, 235, 1))
}

.mask-custom {
background: rgba(24, 24, 16, .2);
border-radius: 2em;
backdrop-filter: blur(15px);
border: 2px solid rgba(255, 255, 255, 0.05);
background-clip: padding-box;
box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
}
    </style>
</head>
<body>
<?php include_once "components/navbar.php"?>

<section class="gradient-custom">
  <div class="container py-5">

    <div class="row">

      <div class="col-md-6 col-lg-5 col-xl-5 mb-4 mb-md-0">

        <h5 class="font-weight-bold mb-3 text-center text-white">Member</h5>

        <div class="card mask-custom">
          <div class="card-body">

            <ul class="list-unstyled mb-0">
              <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                <a href="#!" class="d-flex justify-content-between link-light">
                  <div class="d-flex flex-row">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp" alt="avatar"
                      class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                    <div class="pt-1">
                      <p class="fw-bold mb-0"><?php echo $row['fname']. " " . $row['lname'] ?></p>
                      <p class="small text-white">Hello, Are you there?</p>
                    </div>
                  </div>
                  <div class="pt-1">
                    <p class="small text-white mb-1">Just now</p>
                    <span class="badge bg-danger float-end">1</span>
                  </div>
                </a>
              </li>
              <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                <a href="#!" class="d-flex justify-content-between link-light">
                  <div class="d-flex flex-row">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-1.webp" alt="avatar"
                      class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                    <div class="pt-1">
                      <p class="fw-bold mb-0">Danny Smith</p>
                      <p class="small text-white">Lorem ipsum dolor sit.</p>
                    </div>
                  </div>
                  <div class="pt-1">
                    <p class="small text-white mb-1">5 mins ago</p>
                  </div>
                </a>
              </li>
              <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                <a href="#!" class="d-flex justify-content-between link-light">
                  <div class="d-flex flex-row">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-2.webp" alt="avatar"
                      class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                    <div class="pt-1">
                      <p class="fw-bold mb-0">Alex Steward</p>
                      <p class="small text-white">Lorem ipsum dolor sit.</p>
                    </div>
                  </div>
                  <div class="pt-1">
                    <p class="small text-white mb-1">Yesterday</p>
                  </div>
                </a>
              </li>
              <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                <a href="#!" class="d-flex justify-content-between link-light">
                  <div class="d-flex flex-row">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-3.webp" alt="avatar"
                      class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                    <div class="pt-1">
                      <p class="fw-bold mb-0">Ashley Olsen</p>
                      <p class="small text-white">Lorem ipsum dolor sit.</p>
                    </div>
                  </div>
                  <div class="pt-1">
                    <p class="small text-white mb-1">Yesterday</p>
                  </div>
                </a>
              </li>
              <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                <a href="#!" class="d-flex justify-content-between link-light">
                  <div class="d-flex flex-row">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-4.webp" alt="avatar"
                      class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                    <div class="pt-1">
                      <p class="fw-bold mb-0">Kate Moss</p>
                      <p class="small text-white">Lorem ipsum dolor sit.</p>
                    </div>
                  </div>
                  <div class="pt-1">
                    <p class="small text-white mb-1">Yesterday</p>
                  </div>
                </a>
              </li>
              <li class="p-2 border-bottom" style="border-bottom: 1px solid rgba(255,255,255,.3) !important;">
                <a href="#!" class="d-flex justify-content-between link-light">
                  <div class="d-flex flex-row">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-5.webp" alt="avatar"
                      class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                    <div class="pt-1">
                      <p class="fw-bold mb-0">Lara Croft</p>
                      <p class="small text-white">Lorem ipsum dolor sit.</p>
                    </div>
                  </div>
                  <div class="pt-1">
                    <p class="small text-white mb-1">Yesterday</p>
                  </div>
                </a>
              </li>
              <li class="p-2">
                <a href="#!" class="d-flex justify-content-between link-light">
                  <div class="d-flex flex-row">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
                      class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                    <div class="pt-1">
                      <p class="fw-bold mb-0">Brad Pitt</p>
                      <p class="small text-white">Lorem ipsum dolor sit.</p>
                    </div>
                  </div>
                  <div class="pt-1">
                    <p class="small text-white mb-1">5 mins ago</p>
                    <span class="text-white float-end"><i class="fas fa-check" aria-hidden="true"></i></span>
                  </div>
                </a>
              </li>
            </ul>

          </div>
        </div>

      </div>

      <div class="col-md-6 col-lg-7 col-xl-7">

        <ul class="list-unstyled text-white">
          <li class="d-flex justify-content-between mb-4">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
              class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
            <div class="card mask-custom">
              <div class="card-header d-flex justify-content-between p-3"
                style="border-bottom: 1px solid rgba(255,255,255,.3);">
                <p class="fw-bold mb-0">Brad Pitt</p>
                <p class="text-light small mb-0"><i class="far fa-clock"></i> 12 mins ago</p>
              </div>
              <div class="card-body">
                <p class="mb-0">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                  labore et dolore magna aliqua.
                </p>
              </div>
            </div>
          </li>
          <li class="d-flex justify-content-between mb-4">
            <div class="card mask-custom w-100">
              <div class="card-header d-flex justify-content-between p-3"
                style="border-bottom: 1px solid rgba(255,255,255,.3);">
                <p class="fw-bold mb-0">Lara Croft</p>
                <p class="text-light small mb-0"><i class="far fa-clock"></i> 13 mins ago</p>
              </div>
              <div class="card-body">
                <p class="mb-0">
                  Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                  laudantium.
                </p>
              </div>
            </div>
            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-5.webp" alt="avatar"
              class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
          </li>
          <li class="d-flex justify-content-between mb-4">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
              class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
            <div class="card mask-custom">
              <div class="card-header d-flex justify-content-between p-3"
                style="border-bottom: 1px solid rgba(255,255,255,.3);">
                <p class="fw-bold mb-0">Brad Pitt</p>
                <p class="text-light small mb-0"><i class="far fa-clock"></i> 10 mins ago</p>
              </div>
              <div class="card-body">
                <p class="mb-0">
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                  labore et dolore magna aliqua.
                </p>
              </div>
            </div>
          </li>
          <li class="mb-3">
            <div class="form-outline form-white">
              <textarea class="form-control" id="textAreaExample3" rows="4"></textarea>
              <label class="form-label" for="textAreaExample3">Message</label>
            </div>
          </li>
          <button type="button" class="btn btn-light btn-lg btn-rounded float-end">Send</button>
        </ul>

      </div>

    </div>

  </div>
</section>


<?php include_once "components/footer.php"?>  
</body>
</html>