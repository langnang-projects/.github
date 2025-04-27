const parseBody = function (content) {
    const [start, end] = ['```json', '```'];
    // console.log(content.indexOf(start));
    // console.log(content.lastIndexOf(end));
    // console.log(content.substring(content.indexOf(start) + start.length, content.lastIndexOf(end)))
    // console.log(JSON.parse(content.substring(content.indexOf(start) + start.length, content.lastIndexOf(end))));
    return JSON.parse(content.substring(content.indexOf(start) + start.length, content.lastIndexOf(end)));
};

export default parseBody;