@include('admin.mail.header')

  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin: 15pt 0in 0in 0in;font-size: 11.5pt;color: #727882;background:white;font-family: Arial,Helvetica,sans-serif;line-height: 25px;padding: 0 20pt;">
      <tbody>
          <tr>
              <td style="padding: 10pt 0in 5pt 0in;" colspan="2">
                  <span style="font-size:18px;font-weight:bold;color: #2a3940;">Dear {{ $name }},</span>
              </td>
          </tr>
          <tr>
              <td style="padding: 10pt 0in 0in 0in;">
                  <span>You have requested to reset your password.</span>
              </td>
          </tr>
          <tr>
              <td style="padding: 10pt 0in 0in 0in;">
                  <span>Please use the following link to reset your password:</span>
                  <a href="{{ $link }}">{{ $link }}</a>
              </td>
          </tr>

      </tbody>
  </table>
@include('admin.mail.footer')
