/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */

var MyPosts = MyPosts || {};

MyPosts = {
    remove: function(postId) {
        if(confirm('Você realmente deseja excluir esse post?')) {
            Base.redirect('/post/delete/' + postId);
        }
    }
}
