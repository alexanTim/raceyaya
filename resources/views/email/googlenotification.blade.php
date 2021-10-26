<!DOCTYPE html>
<html>
<head>
 <title>Laravel Send Email Example</title>
</head>
<body>
    <table style="width: 50%;margin: auto;margin-top:50px;
     margin-bottom:50px;border:1px solid #eeeeee;box-shadow: 1px 2px 31px 0px #e0e0e0 inset;                 
  -moz-box-shadow: 1px 2px 31px 0px #e0e0e0 inset;            
  -webkit-box-shadow: 1px 2px 31px 0px #e0e0e0 inset;  
     ">
    <thead>
<tr><th style="background: #64c0ff;padding: 27px;color: #fff;font-size: 26pt;">
<img src="{{asset('images/h-Iogo.png')}}"  width="50%"/>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style=" text-align: center;">
                <table style=" width: 100%;">
                    <tbody><tr>
                        <td><h2>Thank You For Signing Up!</h2></td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;">
                    <tbody>
                        <tr>
                            <td style="text-align: left; padding-left: 80px;">Hello {{$firstname}},<br/>
                                <p>
                                    Welcome to raceyaya,<br>
                                </p>
                                <p>
                                   you can organizer certain event conveniently.  
                                </p>
                                <br/>
                                <p>Thanks </p>
                                <p>Administrator</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style=" width: 100%;">
                    <tbody><tr>
                        <td style="text-align: center; padding-bottom:30px;"><a href="http://youtube.com" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://youtube.com&amp;source=gmail&amp;ust=1581064309281000&amp;usg=AFQjCNFErXvYu4Aex40T9wVuxVQW5XJFZw">youtube.com</a> | <a href="http://youtube.com" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://youtube.com&amp;source=gmail&amp;ust=1581064309281000&amp;usg=AFQjCNFErXvYu4Aex40T9wVuxVQW5XJFZw">youtube.com</a> | <a href="http://faceboo.com" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://faceboo.com&amp;source=gmail&amp;ust=1581064309281000&amp;usg=AFQjCNE9Kax8uMFL7If0_XakTcniy_UgCQ">faceboo.com</a> | <a href="http://twitter.com" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://twitter.com&amp;source=gmail&amp;ust=1581064309281000&amp;usg=AFQjCNGaOVtWcDJy31wxwt56-TZ00nEf-Q">twitter.com</a> </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
 </table>
</body>
</html> 