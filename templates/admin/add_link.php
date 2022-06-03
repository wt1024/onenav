<?php include_once('header.php'); ?>
<?php include_once('left.php'); ?>

<div class="layui-body">
<!-- 内容主体区域 -->
<div class="layui-row content-body place-holder">
    <div class="layui-col-lg12">
    <form class="layui-form layui-form-pane">
    <div class="layui-form-item">
    <label class="layui-form-label">URL</label>
    <div class="layui-input-block">
      <input id = "url" name="url" required  lay-verify="required" placeholder="请输入有效链接" autocomplete="off" class="layui-input"
      value = "<?php echo $_GET["url"]; ?>"
      >
    </div>
  </div>
<!-- 添加备用链接 -->
  <div class="layui-col-lg12">
    <div class="layui-form-item">
    <label class="layui-form-label">备用URL</label>
    <div class="layui-input-block">
      <input type="url" id = "url_standby" name="url_standby" placeholder="请输入备用链接，如果没有，请留空" autocomplete="off" class="layui-input">
    </div>
  </div>
  <!-- 备用链接END -->

  <div class="layui-form-item">
    <label class="layui-form-label">链接名称</label>
    <div class="layui-input-block">
      <input type="text" id = "title" name="title" required  lay-verify="required" placeholder="请输入链接名称" autocomplete="off" class="layui-input"
      value = "<?php echo $_GET["title"]; ?>"
      >
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">所属分类</label>
    <div class="layui-input-block">
      <select name="fid" lay-verify="required" lay-search>
        <option value=""></option>
        <?php foreach ($categorys as $category) {
          # code...
        ?>
        <option value="<?php echo $category['id'] ?>"><?php echo $category['name']; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">权重</label>
    <div class="layui-input-block">
      <input type="number" name="weight" min = "0" max = "999" value = "0" required  lay-verify="required|number" placeholder="权重越高，排名越靠前，范围为0-999" autocomplete="off" class="layui-input">
    </div>
  </div>
  
  
  <div class="layui-form-item">
    <label class="layui-form-label">是否私有</label>
    <div class="layui-input-block">
      <input type="checkbox" name="property" value = "1" lay-skin="switch" lay-text="是|否">
    </div>
  </div>
  
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">描述</label>
    <div class="layui-input-block">
      <textarea name="description" id = "description" placeholder="请输入内容" class="layui-textarea"><?php echo $_GET["title"]; ?>
      </textarea>
    </div>
  </div>
  <div class="layui-form-item">
      <button class="layui-btn" lay-submit lay-filter="add_link">添加</button>
      <!-- <button class="layui-btn" lay-submit lay-filter="get_link_info">识别</button> -->
      <a href="javascript:;" class="layui-btn" onclick="get_link_info()">识别</a>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
  </div>
</form>
    </div>
    
</div>
<!-- 内容主题区域END -->
<div>
                <h5>网页收集小工具</h5>
                <a href="javascript:(function()%7Bvar%20description;var%20desString=%22%22;var%20metas=document.getElementsByTagName('meta');for(var%20x=0,y=metas.length;x%3Cy;x++)%7Bif(metas%5Bx%5D.name.toLowerCase()==%22description%22)%7Bdescription=metas%5Bx%5D;%7D%7Dif(description)%7BdesString=%22&amp;description=%22+encodeURIComponent(description.content);%7Dvar%20win=window.open(%22http://sq.wangt.cc/index.php?c=admin&page=add_link&from=webtool&url=%22+encodeURIComponent(document.URL)+desString+%22&title=%22+encodeURIComponent(document.title)+%22&charset=%22+document.charset,'_blank');win.focus();%7D)();"
                    onclick="alert('请把这个按钮拖到您的浏览器书签栏'); return false;" class="layui-btn">+书签</a>
                <span>(将该按钮拖动至浏览器书签栏)</span>
            </div>
</div>
  
<?php include_once('footer.php'); ?>
