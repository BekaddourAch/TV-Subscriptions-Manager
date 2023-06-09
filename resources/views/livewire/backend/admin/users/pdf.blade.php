<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>A simple, clean, and responsive HTML invoice template</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
		<!-- Invoice styling -->
		<style>
            *{
                direction: rtl;
            }
			body {
				font-family: 'KFGQPC', sans-serif;
				text-align: center;
                display: table;
                direction: rtl;
			}
            table, td, th {
                border: 1px solid;
                text-align: center;
            }

            th{
                background-color: rgb(205, 205, 205);
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

		</style>
	</head>

	<body>
		<h1>A simple, clean, and responsive HTML invoice template</h1>
		<h3>Because sometimes, all you need is something simple.</h3>
        <img src="{{ asset('backend/img/logo.png') }}" width="80px" alt="">
		<div>
            <div class="table-responsive">
                <table class="table p-0 m-3 table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>username</th>
                            <th>mobile</th>
                            <th class="block">email</th>
                            <th>role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles[0]->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6">Users : {{ $users->count() }}</th>
                        </tr>
                    </tfoot>
                </table>
                <p style="text-align: justify">
                    هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
                    إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.
                    ومن هنا وجب على المصمم أن يضع نصوصا مؤقتة على التصميم ليظهر للعميل الشكل كاملاً،دور مولد النص العربى أن يوفر على المصمم عناء البحث عن نص بديل لا علاقة له بالموضوع الذى يتحدث عنه التصميم فيظهر بشكل لا يليق.
                    هذا النص يمكن أن يتم تركيبه على أي تصميم دون مشكلة فلن يبدو وكأنه نص منسوخ، غير منظم، غير منسق، أو حتى غير مفهوم. لأنه مازال نصاً بديلاً ومؤقتاً.
                </p>
            </div>
		</div>
    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	</body>
</html>
