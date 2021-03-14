<?php
session_start();
include 'header.php' ;
 include 'cont.php';
        include 'database.php';
$db = new Database();
$conn = $db->db_connect();
$contat = new Contacts($conn);
        ?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../template/AdminLTE-2.3.7/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../template/AdminLTE-2.3.7/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../template/AdminLTE-2.3.7/dist/css/AdminLTE.min.css">

  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../template/AdminLTE-2.3.7/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../template/AdminLTE-2.3.7/plugins/iCheck/flat/blue.css">
  <link rel="stylesheet" href="../template/AdminLTE-2.3.7/plugins/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="../template/AdminLTE-2.3.7/plugins/fullcalendar/fullcalendar.print.css" media="print">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<div class="wrapper">


  <!-- Left side column. contains the logo and sidebar -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Hover Data Table</h3>
            </div>
            <!-- /.box-header -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <div class="mailbox-controls">
                <div class="table-responsive mailbox-messages">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th><!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                </button></th>
                  <th>Nome</th>
                  <th>Cognome</th>
                  <th>Email</th>
                  <th>Data</th>
                </tr>
                </thead>
                <?php


                //include google api library
                require_once 'google-api-php-client/src/Google/autoload.php';// or wherever autoload.php is located


                //Create a Google application in Google Developers Console for obtaining your Client id and Client secret.
                // https://www.design19.org/blog/import-google-contacts-with-php-or-javascript-using-google-contacts-api-and-oauth-2-0/

                // Your redirect uri should be on a online server. Localhost will not work.

                //Important : Your redirect uri should be added in Google Developers Console , in your Authorized redirect URIs

                include 'config.php';

                //setup new google client
                $client = new Google_Client();
                $client -> setApplicationName('Google Contacts');
                $client -> setClientid($google_client_id);
                $client -> setClientSecret($google_client_secret);
                $client -> setRedirectUri($google_redirect_uri);
                $client -> setAccessType('online');
                $client -> setScopes('https://www.google.com/m8/feeds');
                $googleImportUrl = $client -> createAuthUrl();


                //curl function
                function curl($url, $post = "") {
                	$curl = curl_init();
                	$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
                	curl_setopt($curl, CURLOPT_URL, $url);
                	//The URL to fetch. This can also be set when initializing a session with curl_init().
                	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                	//TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
                	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
                	//The number of seconds to wait while trying to connect.
                	if ($post != "") {
                		curl_setopt($curl, CURLOPT_POST, 5);
                		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
                	}
                	curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
                	//The contents of the "User-Agent: " header to be used in a HTTP request.
                	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
                	//To follow any "Location: " header that the server sends as part of the HTTP header.
                	curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
                	//To automatically set the Referer: field in requests where it follows a Location: redirect.
                	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
                	//The maximum number of seconds to allow cURL functions to execute.
                	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                	//To stop cURL from verifying the peer's certificate.
                	$contents = curl_exec($curl);
                	curl_close($curl);
                	return $contents;
                }


                //google response with contact. We set a session and redirect back
                if (isset($_GET['code'])) {
                	$auth_code = $_GET["code"];
                	$_SESSION['google_code'] = $auth_code;
                }


                /*
                    Check if we have session with our token code and retrieve all contacts, by sending an authorized GET request to the following URL : https://www.google.com/m8/feeds/contacts/default/full
                    Upon success, the server responds with a HTTP 200 OK status code and the requested contacts feed. For more informations about parameters check Google API contacts documentation
                */
                if(isset($_SESSION['google_code'])) {
                	$auth_code = $_SESSION['google_code'];
                	$max_results = 200;
                    $fields=array(
                        'code'=>  urlencode($auth_code),
                        'client_id'=>  urlencode($google_client_id),
                        'client_secret'=>  urlencode($google_client_secret),
                        'redirect_uri'=>  urlencode($google_redirect_uri),
                        'grant_type'=>  urlencode('authorization_code')
                    );
                    $post = '';
                    foreach($fields as $key=>$value)
                    {
                        $post .= $key.'='.$value.'&';
                    }
                    $post = rtrim($post,'&');


                    $result = curl('https://accounts.google.com/o/oauth2/token',$post);
                    $response =  json_decode($result);
                    $accesstoken = $response->access_token;
                    $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&alt=json&v=3.0&oauth_token='.$accesstoken;
                    $xmlresponse =  curl($url);
                    $contacts = json_decode($xmlresponse,true);

                	//deg ($contacts['feed']['entry']);

                	$return = array();
                	if (!empty($contacts['feed']['entry'])) {
                		foreach($contacts['feed']['entry'] as $contact) {

                			//$contactidlink = explode('/',$contact['id']['$t']);
                			//$contactId = end($contactidlink);

                			//retrieve user photo
                			if (isset($contact['link'][0]['href'])) {

                				$url =   $contact['link'][0]['href'];

                				$url = $url . '&access_token=' . urlencode($accesstoken);

                				$curl = curl_init($url);

                		        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                		        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                		        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
                				curl_setopt($curl, CURLOPT_VERBOSE, true);

                		        $image = curl_exec($curl);
                		        curl_close($curl);


                				//echo '<img src="data:image/jpeg;base64,'.base64_encode( $image ).'" />';


                			}

                			//retrieve Name + email and store into array
                			$return[] = array (
                				'name'=> $contact['gd$name']['gd$givenName']['$t'],
                                                'cognome'=> $contact['gd$name']['gd$familyName']['$t'],
                				'email' => $contact['gd$email'][0]['address'],
                				'data' => $contact['updated']['$t'],

                			);
                		}
                	}

                	$google_contacts = $return;

                	unset($_SESSION['google_code']);



?>


                    <tbody>


                  <?php       if(!empty($google_contacts)) {
                          		foreach ($google_contacts as $contact) {
                          			$contat->setNome($contact['name']);

                          			$contat->setCognome($contact['cognome']);
                                                $contat->setEmail($contact['email']);
                                                
                                                
                                                $contat->insert($nome, $cognome, $email);
                                                
                          		}
                          	}

                          }

                          ?>
                          
                </tbody>

              </table>
            </div>
            <!-- /.box-body -->
          </div>
            </div>
          </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>

<?php include 'footer.php' ?>
  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->


<script src="../template/AdminLTE-2.3.7/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../template/AdminLTE-2.3.7/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../template/AdminLTE-2.3.7/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../template/AdminLTE-2.3.7/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../template/AdminLTE-2.3.7/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../template/AdminLTE-2.3.7/plugins/fastclick/fastclick.js"></script>
<script>
  $(function () {
    //Enable iCheck plugin for checkboxes
    //iCheck for checkbox and radio inputs
    $('.mailbox-messages input[type="checkbox"]').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    //Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
      var clicks = $(this).data('clicks');
      if (clicks) {
        //Uncheck all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
      } else {
        //Check all checkboxes
        $(".mailbox-messages input[type='checkbox']").iCheck("check");
        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
      }
      $(this).data("clicks", !clicks);
    });

    //Handle starring for glyphicon and font awesome

  });
</script>
<!-- AdminLTE App -->
<script src="../template/AdminLTE-2.3.7/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../template/AdminLTE-2.3.7/dist/js/demo.js"></script>
<!-- page script -->

<script>
  $(function () {
    $('#example1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
</script>
<!-- iCheck -->
<script src="../template/AdminLTE-2.3.7/plugins/iCheck/icheck.min.js"></script>
<!-- Page Script -->

