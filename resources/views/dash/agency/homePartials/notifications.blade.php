<div class="bg-white rounded-3xl flex flex-col">
    <div class="p-5">
        <h2 class="font-bold"><i class="fa-solid fa-bell mr-2"></i> Notifiche</h2>
    </div>
    <div class="overflow-scroll max-h-70 gap-5 pb-5 flex flex-col">
        <?php foreach ($notifications as $single) { ?>
            <div class="flex items-center gap-3 p-5 py-0">
                <i class="fa-solid fa-comment-dots"></i>
                <div>
                    <h6 class="font-bold">Messaggio da: <?= $single->name ?></h6>
                    <p class="text-sm">{{ \Illuminate\Support\Str::limit($single->message, 300) }}</p>
                    <p class="text-sm"><?= date("d/m/Y", strtotime($single->created_at)) ?></p>
                </div>
            </div>
        <?php }?>
    </div>
</div>
