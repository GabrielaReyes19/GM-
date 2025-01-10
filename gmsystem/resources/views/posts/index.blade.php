
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	@foreach ($posts as $post)
		{{ $post->title }}
	@endforeach
</body>
</html>