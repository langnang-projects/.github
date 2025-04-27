const getQuery = function (str) {
    let result = {};
    var query = decodeURI(str);
    var vars = query.split("&");
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split("=");
        result[pair[0]] = pair[1];
    }
    return result;
}

export default getQuery;