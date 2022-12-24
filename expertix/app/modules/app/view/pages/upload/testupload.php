<div class="q-pa-md">
	<div class="q-gutter-sm row items-start">
		<q-uploader url="upload/" method="post" multiple=false :filter="checkFiles" style="max-width: 300px" @uploaded="onUploadCompleted" @failed="onUploadFailed"></q-uploader>
	</div>
	{{uploadedKeys}}
</div>