<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Roboto:700' rel='stylesheet' type='text/css'>
    @production
        <script type="text/javascript">var _jf = _jf || [];_jf.push(['p','52580']);_jf.push(['initAction',true]);_jf.push(['_setFont','wt064','css','.wt064']);_jf.push(['_setFont','wt064','alias','wt064']);_jf.push(['_setFont','wt064','english','Roboto']);_jf.push(['_setFont','wt064','weight',700]);_jf.push(['_setFont','setofont','css','.setofont']);_jf.push(['_setFont','setofont','alias','setofont']);_jf.push(['_setFont','setofont','english','Roboto ']);_jf.push(['_setFont','setofont','weight',600]);(function(A,p,c,m,l,q,r,h,B,D){var b=A._jf;if(b.constructor!==Object){var t=!0,u=function(a){var f=!0,e;for(e in b)b[e][0]==a&&(f&&(f=f&&!1!==b[e][1].call(b)),b[e]=null,delete b[e])},v=/\S+/g,w=/[\t\r\n\f]/g,C=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,n="".trim,x=n&&!n.call("\ufeff\u00a0")?function(a){return null==a?"":n.call(a)}:function(a){return null==a?"":(a+"").replace(C,"")},k=function(a){var f,b,g;if("string"===typeof a&&a&&(a=(a||"").match(v)||[],f=h[c]?(" "+h[c]+" ").replace(w," "):" ")){for(g=0;b=a[g++];)0>f.indexOf(" "+b+" ")&&(f+=b+" ");h[c]=x(f)}},d=function(a){var b,e,g;if(0===arguments.length||"string"===typeof a&&a){var d=(a||"").match(v)||[];if(b=h[c]?(" "+h[c]+" ").replace(w," "):""){for(g=0;e=d[g++];)for(;0<=b.indexOf(" "+e+" ");)b=b.replace(" "+e+" "," ");h[c]=a?x(b):""}}},y;b.addScript=y=function(b,f,e,g,d,c){d=d||function(){};c=c||function(){};var a=p.createElement("script"),h=p.getElementsByTagName("script")[0],k,m=!1,l=function(){a.src="";a.parentNode.removeChild(a);a=a.onerror=a.onload=a.onreadystatechange=null};g&&(k=setTimeout(function(){l();c()},g));a.type=f||"text/javascript";a.async=e;a.onload=a.onreadystatechange=function(b,c){m||a.readyState&&!/loaded|complete/.test(a.readyState)||(m=!0,g&&clearTimeout(k),l(),c||d())};a.onerror=function(a,b,d){g&&clearTimeout(k);l();c();return!0};a.src=b;h.parentNode.insertBefore(a,h)};for(var z in b)"initAction"==b[z][0]&&(t=b[z][1]);b.push(["_eventPreload",function(){1==t&&k(m);y(B,null,!1,3E3,null,function(){u("_eventInactived")})}]);b.push(["_eventReload",function(){d(r);d(q);k(l)}]);b.push(["_eventActived",function(){d(m);d(l);k(q)}]);b.push(["_eventInactived",function(){d(m);d(l);k(r)}]);u("_eventPreload")}})(this,this.document,"className","jf-loading","jf-reloading","jf-active","jf-inactive",this.document.getElementsByTagName("html")[0],"//ds.justfont.com/js/stable/v/6.1/id/228051997753");</script>
    @endproduction
    @if(env('app_env')==="local")
        <script src="//s3-ap-northeast-1.amazonaws.com/justfont-user-script/jf-52580.js"></script>
    @endif
    <title>@yield('title')</title>
    <!-- Link to CSS -->
</head>
<body>
<header>
    @if($menu)
        @include('layouts.menu')
    @endif
</header>

<div class="container1">
    @yield('content')
</div>

<footer>
    @if($footer)
        @include('layouts.footer')
    @endif
</footer>
</body>
</html>
