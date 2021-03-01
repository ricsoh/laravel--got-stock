// => ME, Dynamically change the subcat options based on the main cate selected
var categoryLists = {};

// => ME, user view called for onchange event. 
function categoryChange(selectObj, recObj_arr, recCatResults_arr, from)
{   
    // => ME, create the array for shop or user view
    switch (from)
    {
        case 'shop':
            createList_arr_Shop(recObj_arr, recCatResults_arr);
            break;
        case 'user':
            createList_arr_User(recObj_arr, recCatResults_arr);
            break;
        default:
    }

    // => ME, clear previous row/s by table id
    $("#postShowTable tr>td").remove();

    // get the index of the 1st selected option 
    var idx = selectObj.selectedIndex;
    // get the value of the 1st selected option 
    var catSelected = selectObj.options[idx].value;

    // use the selected option value to retrieve the list of items from the categoryLists array 
    cList = categoryLists[catSelected];
    // get the category select element via its known id 
    var cSelect = document.getElementById("post_subcat_1_sel");
    // remove the current options from the category select 
    var len = cSelect.options.length;
    while (cSelect.options.length > 0) {
        cSelect.remove(0);
    }

    // create new options 
    var newOption;

    for (var i = 0; i < cList.length; i++) {
        newOption = document.createElement("option");
        newOption.value = cList[i]; // assumes option string and value are the same 
        newOption.text = cList[i];
        // add the new option 
        try {
            cSelect.add(newOption); // this will fail in DOM browsers but is needed for IE 
        } catch (e) {
            cSelect.appendChild(newOption);
        }
    }
}

// => ME, create the array for shop view
function createList_arr_Shop(categories_arr, catResults_arr)
{   
    for (var x = 0; x < catResults_arr.length; x++){
        var Temp_count = 0;
        for (var y = 0; y < categories_arr.length; y++){
            if (categories_arr[y].main_cat == catResults_arr[x]){
                if (Temp_count == 0){
                    categoryLists['Select a Main Category'] = ['First select a Main Category']; // => Create the 1st value
                    categoryLists[catResults_arr[x]] = [categories_arr[y].subcat_1]; // => Create the 2nd value
                    Temp_count++;
                }else{
                    categoryLists[catResults_arr[x]].push(categories_arr[y].subcat_1); // => insert new value
                }
            }
        }
    }
}

// => ME, create the array for user view
function createList_arr_User(posts_arr, catResults_arr)
{
    categoryLists['Select a Main Category'] = ['First select a Main Category']; // => Create the 1st row
    // => ME, user select main cat as "All", will have all items in subcat for selection
    categoryLists['All'] = ['Select', 'All']; // => Create the 2nd row   
    for (var y = 0; y < posts_arr.length; y++){
        categoryLists['All'].push(posts_arr[y].subcat_1); // => insert new value
    }
    categoryLists['All'] = [...new Set(categoryLists['All'])]; // => remove duplicate value
     // => Create the 3rd and above row/s
    for (var x = 0; x < catResults_arr.length; x++){
        var Temp_count = 0;
        for (var y = 0; y < posts_arr.length; y++){
            if (posts_arr[y].main_cat == catResults_arr[x]){
                if (Temp_count == 0){
                    categoryLists[catResults_arr[x]] = ['Select', 'All']; // => Create the 1st value
                    categoryLists[catResults_arr[x]].push(posts_arr[y].subcat_1); // => Create the 3rd value
                    Temp_count++;
                }else{
                    categoryLists[catResults_arr[x]].push(posts_arr[y].subcat_1); // => insert new value
                }
            }
        }
    categoryLists[catResults_arr[x]] = [...new Set(categoryLists[catResults_arr[x]])]; // => remove duplicate value
    }
}

// => ME, Dynamically generate and show table rows by selected options for user view
function selectOnchangeFunction(temp_post_arr, profile_arr, sort)
{
// => ME, for sorting (update => this was replaced by passing the array thru' function)
//    temp_post_arr = JSON.parse(JSON.stringify(post_arr)); // => ME, deep clone so that the original object array not affected by sorting

    switch (sort)
    {
        case 'down':
            // Sort the array temp_post_arr
            temp_post_arr.sort((a, b) => (a.price > b.price) ? 1 : -1); // => sort low to high
            break;
        case 'up':
            // Sort the array temp_post_arr
            temp_post_arr.sort((a, b) => (a.price > b.price) ? -1 : 1); // => sort high to low
            break;
        case 'no_sort':
        default:
    }
    // => ME, clear previous row/s by table id
    $("#postShowTable tr>td").remove();

    // => ME, get the form data
    var formData = document.getElementById("selectFilter");
    // => ME, generate and attached rows to table
    var table = document.getElementById("postShowTable");
    var row = table.insertRow(1); // Change the number to insert to different row...

    for (var i = 0; i < temp_post_arr.length; i++) {
        if ((formData.post_subcat_1_sel.value == "All") || (formData.post_subcat_1_sel.value == temp_post_arr[i].subcat_1)) {
            if ((formData.post_main_cat_sel.value == "All") || (formData.post_main_cat_sel.value == temp_post_arr[i].main_cat)) {
                // => ME, start inserting rows
                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell5 = row.insertCell(4);
                var cell6 = row.insertCell(5);
                var cell7 = row.insertCell(6);
                var cell8 = row.insertCell(7);
                var cell9 = row.insertCell(8);
                var cell10 = row.insertCell(9);
                cell1.innerHTML = temp_post_arr[i].main_cat;
                cell2.innerHTML = temp_post_arr[i].subcat_1;
                cell3.innerHTML = temp_post_arr[i].brand;
                cell4.innerHTML = temp_post_arr[i].description;
                cell5.innerHTML = temp_post_arr[i].qty;
                cell6.innerHTML = "";
                cell7.innerHTML = temp_post_arr[i].price;
                cell8.innerHTML = "";

                // => ME, for modal image
                var myModal = "myModal" + i;
                var myImg = "myImg" + i;
                var img01 = "img01" + i;
                var mySpan = "mySpan" + i;
                var myCaption = "myCaption" + i;
                cell9.innerHTML = "<img id='" + myImg + "' src=/storage/" + temp_post_arr[i].image + " alt='" + temp_post_arr[i].description + "' height='50' width='50' onload=\"onloadImageModal('" + myModal + "', '" + myImg + "', '" + img01 + "', '" + mySpan + "', '" + myCaption + "')\"><div id='" + myModal + "' class='modal'><span id='" + mySpan + "' class='close'>&times</span><img class='modal-content' id='" + img01 + "'><div id='" + myCaption + "'></div></div>";
                // => ME, Go thru the profile to get the user's profile name and website
                for (var x = 0; x < profile_arr.length; x++) {
                    if (temp_post_arr[i].user_id == profile_arr[x].user_id) {
                        cell10.innerHTML = "<a href='http://" + profile_arr[x].website + "' target='_blank'>" + profile_arr[x].name + "</a>";
                    }
                }
            }
        }   
        row = table.insertRow(2+i); // indexing the row number to insert
    }
}

