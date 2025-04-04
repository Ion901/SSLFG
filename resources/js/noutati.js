import {startlightbox} from './lightbox';

startlightbox();



// async function fetchSuggestedPosts(){
//     let href = document.location.href;
//     let slug= href.match('noutati\/(.*)')[1];

//     try{
//         const response = await fetch(`/noutati?post_slug=${encodeURIComponent(slug)}`,{
//             method: 'get',
//             headers:{
//                 'Content-type' : "application/json",
//             },
//         });
//         if(!response.ok){
//             throw new Error('Ceva e in neregula');
//         }
//         const apiResponse = await response.json();
//         console.info(apiResponse);

//     }
//     catch(error){
//         console.error(error);
//     } finally {
//       console.log('API call completed');
//     }
// }
// fetchSuggestedPosts()
