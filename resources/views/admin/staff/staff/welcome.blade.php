@extends('layouts.mail')

@section('body')

<tr>
    <td align="center" valign="top">
        <table bgcolor="#f9fafa" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
            <tbody>
                <tr>
                    <td align="center" valign="top">
                        <table align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100" style="padding:60px 0px 20px;" width="800">
                            <tbody>
                                <tr>
                                    <td align="center" class="alg_center" valign="top">
                                        <p style="color:#3c3f5a; font-size:16px; font-weight:600; margin:12px 0px; text-transform:uppercase; letter-spacing:2px; line-height:24px;">
                                            Hello {{$name}}, <br>
                                            Your Account Has Been Activateed.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="100%">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top">
                                        <table  align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="560">
                                            <tbody>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <table style="border-radius:4px;" bgcolor="#29274c" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100"  width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" class="alg_center" valign="top">
                                                                        <p style="color:#fff; font-size:14px; font-weight:600; margin:12px 0px 0px;">
                                                                            Account Credentials
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" class="alg_center" valign="top">
                                                                        <p style="color:#fff; font-size:12px; font-weight:400; margin:6px 0px 12px;">
                                                                            Here are the login details for dashboard and staff app access.
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:4px 0px 0px;" align="center" valign="top">
                                        <table bgcolor="#fff" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" style="padding:4px 0px 2px; border-radius:4px;" width="560">
                                            <tbody>
                                                <tr>
                                                    <td style="padding:0px 0px 20px;" align="center" valign="top">

                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100"  width="560">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:0px 20px" align="left" class="alg_center" valign="top">
                                                                        <table bgcolor="#fff" align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100"  width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left" class="alg_center" valign="top">
                                                                                        <p style="color:#3c3f5a; font-size:11px; font-weight:500; margin:12px 0px 7px;">
                                                                                            Name:
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding:7px 10px; border-radius:4px;" bgcolor="#edf1f5" align="left" class="alg_center" valign="top">
                                                                                        <p style="color:#3c3f5a; font-size:13px; font-weight:500; margin:0px 0px 0px;">
                                                                                            {{$name}}
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100"  width="560">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:0px 20px" align="left" class="alg_center" valign="top">
                                                                        <table bgcolor="#fff" align="left" border="0" cellpadding="0" cellspacing="0" class="wrap100"  width="49%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left" class="alg_center" valign="top">
                                                                                        <p style="color:#3c3f5a; font-size:11px; font-weight:500; margin:12px 0px 7px;">
                                                                                            User Name:
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding:7px 10px; border-radius:4px;" bgcolor="#edf1f5" align="left" class="alg_center" valign="top">
                                                                                        <p style="color:#3c3f5a; font-size:13px; font-weight:500; margin:0px 0px 0px; border-radius:4px;">
                                                                                            {{$email}}
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                        <table bgcolor="#fff" align="right" border="0" cellpadding="0" cellspacing="0" class="wrap100"  width="49%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left" class="alg_center" valign="top">
                                                                                        <p style="color:#3c3f5a; font-size:11px; font-weight:500; margin:12px 0px 7px;">
                                                                                            Password:
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="padding:7px 10px; border-radius:4px;" bgcolor="#edf1f5" align="left" class="alg_center" valign="top">
                                                                                        <p style="color:#3c3f5a; font-size:13px; font-weight:500; margin:0px 0px 0px; border-radius:4px;">
                                                                                            {{$password}}
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:4px 0px 0px;" align="center" valign="top">
                                        <table style="border-radius:4px;" bgcolor="#fff" align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="560">
                                            <tbody>
                                                <tr>
                                                    <td style="padding:10px 40px;" align="center" valign="top">
                                                        <p style="color:#3c3f5a; font-size:11px; font-weight:500; margin:0px 0px; line-height:16px;">
                                                            This is an auto generated password. <br>
                                                            We recommended you to change the password after first login.
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:7px 0px 160px;" align="center" valign="top">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0" class="wrap100" width="560">
                                            <tbody>
                                                <tr>
                                                    <td style="padding:4px 0px;" align="center" valign="top">
                                                        <a href="{{route('login')}}" style="color:#fff; font-size:16px; font-weight:600; margin:0px 0px; background:#29274c; padding:10px 0px; display:inline-block; text-decoration:none; width:100%; border-radius:4px;">
                                                            Access Website
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>

@endsection
