@props(['view' => false,'edit' => false,'delete' => false,'add' => false])

<a {{$attributes}}  >
<button @class([
    'bg-orange-400 hover:bg-orange-500 border-none rounded-md' => $view,
    'bg-yellow-400 hover:bg-yellow-500 border-none rounded-md' => $edit,
    'bg-red-400 hover:bg-red-500 border-none rounded-md' => $delete,
    '!w-[150px] !h-[45px] p-2 text-sm justify-self-center bg-green-400 hover:bg-green-500 border-none rounded-md' => $add,
    "pt-1 pb-2 m-1 w-[60px] h-[60%]"
    ]) >
    {{$slot}}
    </button>
</a>
