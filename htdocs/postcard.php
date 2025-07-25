<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Enter E-mail Data</title>
  <style>
    td {
      vertical-align: top;
    }
  </style>
</head>
<body>
  <form method="post" action="sendmail.php">
    <table>
      <tr>
        <td>To:</td>
        <td><input type="text" name="to_address" size="40"/></td>
      </tr>
      <tr>
        <td>From:</td>
        <td><input type="text" name="from_address" size="40"/></td>
      </tr>
      <tr>
        <td>Subject:</td>
        <td><input type="text" name="subject" size="40"/></td>
      </tr>
      <tr>
        <td valign="top">Message:</td>
        <td>
          <textarea cols="60" rows="10" name="message">Enter your message here.</textarea>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <input type="submit" value="Send"/>
          <input type="reset" value="Reset"/>
        </td>
      </tr>
    </table>
  </form>
</body>
</html>
