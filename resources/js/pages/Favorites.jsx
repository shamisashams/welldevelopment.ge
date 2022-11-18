import React, {useState} from "react";
import { projects } from "../components/Data";
import { ProjectBox } from "../components/ProjectBoxes";
import Layout from "../Layouts/Layout";
import axios from "axios";

const Favorites = ({seo}) => {

    let _cart = localStorage.getItem("welldevelopment_favorite");
    let cart;
    if (_cart !== null) {
        cart = JSON.parse(_cart);
    } else cart = [];

    let product_id = [];

    cart.map((item,index) => {
        product_id.push(item.product.id)
    })

    console.log('favorites',cart,product_id)
    const [products, setProducts] = useState([]);

    axios.get(route('client.favorite.get'), {params: {product_id: product_id}}).then(function (response) {
        // handle success
        console.log(response);
        setProducts(response.data)
    });



  return (
      <Layout seo={seo}>
          <section className="wrapper py-20">
              <div className="text-xl bold mb-10">ფავორიტები</div>
              <div className="grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 gap-y-10 gap-x-5 pb-5">
                  {products.map((item, index) => {
                      return (
                          <ProjectBox
                              key={index}
                              link={route('client.apartment.show',item.slug)}
                              img={item.latest_image?item.latest_image.full_url:null}
                              title={item.title}
                              para={item.short_description}
                              bedroom={item.bedroom}
                              bathroom={item.bathroom}
                              dimension={item.dimension}
                              active={item.action === 1 ? true:false}
                              product={item}
                              favorite={true}
                          />
                      );
                  })}
              </div>
          </section>
      </Layout>

  );
};

export default Favorites;
