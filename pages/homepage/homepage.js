// function load_data(query)
// {
// 	if(query.length > 2)
// 	{
//         let response; 
//         fetch("data.json").then(response => response.ok ? response.text() : null)
//             .then(text => response = text)

//         var html = '<div class="list-group">';

//         if(response.length > 0)
//         {
//             for(var count = 0; count < response.length; count++)
//             {
//                 html += '<a href="#" class="list-group-item list-group-item-action" onclick="get_text(this)">'+response[count].post_title+'</a>';
//             }
//         }
//         else
//         {
//             html += '<a href="#" class="list-group-item list-group-item-action disabled">No Data Found</a>';
//         }

//         html += '</div>';

//         document.getElementById('search_result').innerHTML = html;
// 	}
// 	else
// 	{
// 		document.getElementById('search_result').innerHTML = '';
// 	}
// }
