
  <!-- Bootstrap core CSS-->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin.css" rel="stylesheet">
  <!-- Animation-->
  <link href="css/animate.css" rel="stylesheet">

  <style media="screen">
  .ch-topbar {
  width: 100%;
  border-bottom: solid 1px #E5E5E5;
  background: #FFFFFF;
  box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.08);
  font-size: 0;
  }

  .ch-topbar .grid-lt {
    width: 25%;
    display: inline-block;
    vertical-align: middle;
    padding: 10px;
  }

  .ch-topbar .grid-rt {
    width: 75%;
    height: 32px;
    display: inline-block;
    text-align: right;
    vertical-align: middle;
    padding: 0 10px;
  }

  .ch-share-brick {
    padding: 0 5px;
    border-radius: 5px;
    color: #534e5c;
    background: #FFFFFF;
    transition: .25s ease-in;
    transform: translateY(0px);
    display: inline-block;
    text-decoration: none;
    margin: 0 2px;
  }

  .ch-share-brick:hover {
    box-shadow: 0px 6px 20px 0px rgba(0, 0, 0, 0.1);
  }

  .ch-share {
    width: 32px;
    height: 32px;
    display: inline-block;
    vertical-align: middle;
    opacity: .75;
    transition: .25s ease-in;
  }

  .ch-share-text,
  .ch-starcount {
    display: inline-block;
    vertical-align: middle;
    color: #534e5c;
    font-size: 16px;
    margin-left: 3px;
  }

  .ch-share:hover {
    opacity: 1;
  }

  .twitter {
    background-image: url("../images/icon-twitter.svg");
  }

  .facebook {
    background-image: url("../images/icon-facebook.svg");
  }

  .github {
    background-image: url("../images/icon-github.svg");
  }


  .ch-paper {
    width: 100%;
    max-width: 1600px;
    text-align: center;
    margin: 20px auto;
  }

  .ch-footer {
    text-align: center;
    padding: 0 0 25px 0;
  }

  .ch-gradient-brick {
    width: 150px;
    display: inline-block;
    border-radius: 12px;
    margin: 15px;
    box-shadow: 0px 0px 51px 0px rgba(0, 0, 0, 0.08), 0px 6px 18px 0px rgba(0, 0, 0, 0.05);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    transform: translateY(0px);
  }

  .ch-gradient-brick:hover {
    box-shadow: 0px 0px 114px 0px rgba(0, 0, 0, 0.08), 0px 30px 25px 0px rgba(0, 0, 0, 0.05);
    transform: translateY(-5px);
  }

  .ch-gradient {
    border-radius: 12px 12px 0px 0px;
    width: 100%;
    height: 75px;
    position: relative;
    background-color: #CFD8DC;
  }

  .ch-actions {
    display: none;
    position: absolute;
    right: 5px;
    bottom: 5px;
  }

  .ch-gradient-brick:hover .ch-actions {
    display: block;
    animation: micro-move .3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .ch-code,
  .ch-grab {
    width: 26px;
    height: 26px;
    display: inline-block;
    background-image: url("../images/coolhue-sprite.svg");
    background-repeat: no-repeat;
    cursor: pointer;
    vertical-align: middle;
    margin: 3px;
    transform: translateY(0px);
    transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: .7;
  }

  @keyframes micro-move {
    from {
        transform: translateY(5px);
    }
    to {
        transform: translateY(0px);
    }
  }

  .ch-code:hover,
  .ch-grab:hover {
    opacity: 1;
    transform: translateY(-4px);
  }

  .ch-code:active,
  .ch-grab:active {
    opacity: 1;
    transform: translateY(-2px);
  }

  .ch-code {
    background-position: -26px 0px;
  }

  .ch-grab {
    background-position: 0px 0px;
  }

  .ch-colors {
    border-radius: 0px 0px 12px 12px;
    padding: 12px;
    text-align: left;
    text-transform: uppercase;
    font-size: 18px;
  }

  .ch-color-from {
    margin-bottom: 3px;
  }

  .ch-color-from,
  .ch-color-to {
    color: #929197;
    display: block;
    padding: 0px;
  }

  .ch-notify-plank {
    position: fixed;
    width: 260px;
    max-width: 80%;
    top: 30px;
    right: 0;
    z-index: 500;
    text-align: right;
  }

  .ch-notify {
    margin: 0px 35px 10px 0px;
    background-color: #FFFFFF;
    box-shadow: 0px 4px 15.36px 0.64px rgba(0, 0, 0, 0.1), 0px 2px 6px 0px rgba(0, 0, 0, 0.12);
    padding: 10px 20px;
    color: #534E5C;
    display: inline-block;
    border-radius: 500px;
    font-size: 18px;
    transition: .35s ease-in-out;
  }

  .ch-notify-animate {
    animation: notify-up 2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
  }

  .ch-distro {
    position: fixed;
    z-index: 50;
    right: 15px;
    bottom: 15px;
    min-width: 200px;
    max-width: 100%;
  }

  .ch-distro-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    position: absolute;
    right: 0px;
    bottom: 0px;
    background-color: #FFFFFF;
    background-image: url("../images/coolhue-sprite.svg");
    background-repeat: no-repeat;
    background-position: 0px -25px;
    box-shadow: 0px 12px 27px 3px rgba(0, 0, 0, 0.15), 0px 6px 4px 0px rgba(0, 0, 0, 0.05);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    transform: translateY(0px);
    cursor: pointer;
  }

  .ch-distro-icon-active,
  .ch-distro-icon:hover {
    box-shadow: 0px 25px 30px 5px rgba(0, 0, 0, 0.1), 0px 5px 20px 5px rgba(0, 0, 0, 0.03);
    transform: translateY(-6px);
  }

  .ch-distro-icon-active {
    background-position: -50px -25px;
  }

  .ch-distro-wrapper {
    left: 0px;
    right: 0px;
    bottom: 70px;
    position: absolute;
    background-color: #FFFFFF;
    box-shadow: 0px 0px 51px 0px rgba(0, 0, 0, 0.08), 0px 6px 18px 0px rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    padding: 15px;
    display: none;
  }

  .ch-distro-type {
    color: #2750C4;
    display: block;
    padding: 7px 0 7px 0;
    text-decoration: none;
    font-size: 17px;
    background-position: left center;
    background-repeat: no-repeat;
  }

  .ch-distro-type:hover {
    text-decoration: underline;
  }

  .ch-distro-type:before {
    content: "";
    width: 26px;
    height: 26px;
    display: inline-block;
    vertical-align: middle;
    margin-top: -3px;
    margin-right: 7px;
  }

  .ch-distro-type:nth-child(1):before {
    background-image: url("../images/coolhue-sprite.svg");
    background-position: 0px -77px;
  }

  .ch-distro-type:nth-child(2):before {
    background-image: url("../images/coolhue-sprite.svg");
    background-position: -26px -77px;
  }

  .ch-distro-type:nth-child(3):before {
    background-image: url("../images/coolhue-sprite.svg");
    background-position: -52px -77px;
  }

  .ch-distro-wrapper-flap-up {
    animation: flap-up 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .ch-distro-wrapper-flap-down {
    animation: flap-down 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  }

  .ch-distro-wrapper-visible {
    display: block;
  }
  p {
    margin-bottom: 0;
  }
</style>
<style>
  .custom-label {
    display: inline-flex;
    align-items: center;
    cursor: pointer;
  }

  .custom-label-text {
    margin-left: 8px;
  }

  .custom-toggle {
    isolation: isolate;
    position: relative;
    height: 20px;
    width: 40px;
    border-radius: 13px;
    background: #d6d6d6;
    overflow: hidden;
  }

  .custom-toggle-inner {
    z-index: 2;
    position: absolute;
    top: 1px;
    left: 1px;
    height: 18px;
    width: 38px;
    border-radius: 13px;
    overflow: hidden;
  }

  .custom-active-bg {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 200%;
    background: #1d8836;
    transform: translate3d(-100%, 0, 0);
    transition: transform 0.05s linear 0.17s;
  }

  .custom-toggle-state {
    display: none;
  }

  .custom-indicator {
    height: 100%;
    width: 200%;
    background: white;
    border-radius: 13px;
    transform: translate3d(-75%, 0, 0);
    transition: transform 0.35s cubic-bezier(0.85, 0.05, 0.18, 1.35);
  }

  .custom-toggle-state:checked ~ .custom-active-bg {
     transform: translate3d(-50%, 0, 0);
  }

  .custom-toggle-state:checked ~ .custom-toggle-inner .custom-indicator {
    transform: translate3d(25%, 0, 0);
  }

  #preloader  {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #fefefe;
    z-index: 99;
    height: 100%;
 }
 #status  {
    width: 200px;
    height: 200px;
    position: absolute;
    left: 50%;
    top: 50%;
    background-image: url(https://w3lessons.info/demo/jquery-preloader/ajax-loader.gif);
    background-repeat: no-repeat;
    background-position: center;
    margin: -100px 0 0 -100px;
  }
  
  /* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
.modalspin {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('https://i.stack.imgur.com/FhHRx.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading .modalspin {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modalspin {
    display: block;
}
</style>
