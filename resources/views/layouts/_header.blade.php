@section('search')

  <van-search
    v-model="value"
    placeholder="请输入搜索关键词"
    @input="onSearch"
    @clear="onCancel"

  />
</van-search>

<div class="weui-cells searchbar-result" v-if="searchResult" id="searchResult">
            <div class="weui-cell weui-cell_active weui-cell_access">
                <div class="weui-cell__bd weui-cell_primary" v-for="book in result">
                    <p><a :href="'https://book.edushu.co/books/'+ book.id"><img :src="'https://book.edushu.co/' + book.image" width="80px"/></a></p>
                </div>
            </div>
</div>
@show
