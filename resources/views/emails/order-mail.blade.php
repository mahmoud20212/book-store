<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>تأكيد الطلب</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f3f5f7;
      font-family: Tahoma, Arial, sans-serif;
      color: #1f2937;
    }

    .wrapper {
      width: 100%;
      padding: 24px 12px;
      box-sizing: border-box;
    }

    .container {
      max-width: 680px;
      margin: 0 auto;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 14px;
      overflow: hidden;
    }

    .header {
      background: linear-gradient(120deg, #0ea5e9 0%, #0369a1 100%);
      color: #ffffff;
      padding: 22px 26px;
    }

    .header h1 {
      margin: 0;
      font-size: 22px;
      line-height: 1.4;
      font-weight: 700;
    }

    .body {
      padding: 24px 26px 8px;
      line-height: 1.8;
      font-size: 15px;
    }

    .note {
      margin: 0 0 16px;
      color: #4b5563;
    }

    .order-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 12px;
      margin-bottom: 12px;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      overflow: hidden;
    }

    .order-table thead th {
      background: #f8fafc;
      color: #111827;
      font-size: 14px;
      font-weight: 700;
      padding: 12px 10px;
      border-bottom: 1px solid #e5e7eb;
      text-align: right;
    }

    .order-table tbody td {
      padding: 11px 10px;
      border-bottom: 1px solid #f1f5f9;
      font-size: 14px;
      text-align: right;
    }

    .order-table tbody tr:last-child td {
      border-bottom: 0;
    }

    .total-row td {
      background: #f8fafc;
      font-weight: 700;
      border-top: 2px solid #cbd5e1;
      border-bottom: 0;
      padding-top: 14px;
      padding-bottom: 14px;
    }

    .total-value {
      color: #0f766e;
      font-size: 16px;
    }

    .footer {
      padding: 0 26px 24px;
      color: #6b7280;
      font-size: 13px;
    }

    @media (max-width: 640px) {
      .header,
      .body,
      .footer {
        padding-right: 14px;
        padding-left: 14px;
      }

      .header h1 {
        font-size: 19px;
      }

      .order-table thead th,
      .order-table tbody td {
        font-size: 13px;
        padding: 9px 8px;
      }
    }
  </style>
</head>

<body dir="rtl">
  <div class="wrapper">
    <div class="container">
      <div class="header">
        <h1>تأكيد استلام الطلب</h1>
      </div>

      <div class="body">
        <p class="note">مرحبًا {{ $user->name }}</p>
        <p class="note">لقد استلمنا طلبك بنجاح. فيما يلي تفاصيل الكتب المطلوبة:</p>

        <table class="order-table" role="presentation" cellpadding="0" cellspacing="0">
          <thead>
            <tr>
              <th>عنوان الكتاب</th>
              <th>السعر</th>
              <th>عدد النسخ</th>
              <th>السعر الإجمالي</th>
            </tr>
          </thead>
          <tbody>
            @php
              $subTotal = 0;
            @endphp

            @foreach ($order as $product)
              @php
                $lineTotal = $product->price * $product->pivot->number_of_copies;
                $subTotal += $lineTotal;
              @endphp
              <tr>
                <td>{{ $product->title }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->pivot->number_of_copies }}</td>
                <td>${{ number_format($lineTotal, 2) }}</td>
              </tr>
            @endforeach

            <tr class="total-row">
              <td colspan="3">المجموع الكلي</td>
              <td class="total-value">${{ number_format($subTotal, 2) }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="footer">
        شكرًا لاختيارك مكتبة حسوب. نتمنى لك قراءة ممتعة.
      </div>
    </div>
  </div>
</body>

</html>