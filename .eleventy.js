module.exports = function(eleventyConfig) {

eleventyConfig.addPassthroughCopy('./src/mainstyle.css');
eleventyConfig.addPassthroughCopy('./src/telegram.png');
eleventyConfig.addPassthroughCopy('./src/VK.png');
eleventyConfig.addPassthroughCopy('./src/webscript.js')




return {
    dir: {
        input:"src",
        output:"public"
    }
};
}
