
<ul class="menu-left-item">
  <li>
    <a href="#" class="spotify"><span>Góp ý</span><b class="entypo-mail"></b></a>
  </li>
  <li>
    <a href="#" class="soundcloud"><span>Báo lỗi</span><b class="entypo-attention"></b></a>
  </li>
  <li>
    <a href="#" class="skype"><span>Yêu cầu phim</span><b class="entypo-upload"></b></a>
  </li>
  <!--<li>
    <a href="#" class="dribbble"><span></span><b class=""></b></a>
  </li>-->
</ul>
<div class="menu-left">
  <h1>Floating social icon buttons</h1>
  <p>Icon credit to <a href="http://danielbruce.se/">Daniel Bruce</a> and <a href="http://weloveiconfonts.com/">We Love Icons</a></p>
</div>
<style>
@import url(http://weloveiconfonts.com/api/?family=entypo);
*,
*:before,
*:after {
  box-sizing: border-box;
}

.menu-left-item {
  list-style: none;
  position: fixed;
  top: 50%;
  left: 0%;
  padding:0px;
  -webkit-transform: translateY(-50%);
          transform: translateY(-50%);
  z-index: 9999;
  font-weight: 600;
}
.menu-left-item li a {
  display: block;
  margin-left: -2px;
  height: 50px;
  width: 60px;
  border-radius: 0 5px 5px 0;
  border: 2px solid #000;
  background: #FFF;
  margin-bottom: 1em;
  transition: all .4s ease;
  color: #2980b9;
  text-decoration: none;
  line-height: 50px;
  position: relative;
}
.menu-left-item li a:hover {
  cursor: pointer;
  width: 140px;
  color: #fff;
}
.menu-left-item li a:hover span {
  left: 0;
}
.menu-left-item li a span {
  padding: 0 30px 0 15px;
  position: absolute;
  left: -120px;
  transition: left .4s ease;
}
.menu-left-item li a b {
  position: absolute;
  top: 50%;
  right: 20px;
  -webkit-transform: translateY(-50%);
          transform: translateY(-50%);
  font-size: 1.5em;
}
.menu-left-item li .spotify {
  background: rgba(39, 174, 96, 0.1);
  border-color: #27ae60;
  color: #27ae60;
}
.menu-left-item li .spotify:hover {
  background: #27ae60;
}
.menu-left-item li .soundcloud {
  background: rgba(230, 126, 34, 0.1);
  border-color: #e67e22;
  color: #e67e22;
}
.menu-left-item li .soundcloud:hover {
  background: #e67e22;
}
.menu-left-item li .skype {
  background: rgba(34, 167, 240, 0.1);
  border-color: #22A7F0;
  color: #22A7F0;
}
.menu-left-item li .skype:hover {
  background: #22a7f0;
}
.menu-left-item li .dribbble {
  background: rgba(210, 82, 127, 0.1);
  border-color: #D2527F;
  color: #D2527F;
}
.menu-left-item li .dribbble:hover {
  background: #d2527f;
}

/* entypo */
[class*="entypo-"]:before {
  font-family: 'entypo', sans-serif;
}
[class*="fontawesome-"]:before {
  font-family: 'fontawesome', sans-serif;
}

.menu-left {
  text-align: center;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -60%);
          transform: translate(-50%, -60%);
}
.menu-left h1 {
  font-weight: 600;
  font-size: 2.4em;
  color: #303030;
  margin-bottom: .5em;
}
.menu-left p {
  color: #999;
  font-weight: 400;
  font-size: 1.2em;
}
.menu-left a {
  color: #4183D7;
  text-decoration: none;
  font-weight: 600;
  padding-bottom: 2px;
  border-bottom: 2px dotted #4183D7;
  transition: all .25s ease;
}
.menu-left a:hover {
  color: #D2527F;
  border-color: #D2527F;
}    
</style>

<div class="footer">
    <div class="container" style="padding: 15px;">        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-center">
                <span>© 2018 &nbsp;{{session('website_name')}}. All rights reserved | &nbsp;{{session('website_email')}}</span>
            </div>            
            <div class="clearfix"></div>
        </div>
    </div>
</div>