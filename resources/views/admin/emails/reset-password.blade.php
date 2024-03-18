<h3>هذه رساله لإعاده تعيين الرقم السري الخاص بكم</h3>
<h3>برجاء إستخدام الرقم السري التالي : {{ $details['password'] }}</h3>

<a href="{{ route('admin.password.change', ['email' => $details['email']]) }}" class="btn btn-primary"> إضغط هنا لتغيير
    الرقم السري</a>
مع تحيات فريق عمل,<br>
{{ config('app.name') }}
