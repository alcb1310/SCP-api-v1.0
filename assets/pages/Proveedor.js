import axios from "axios";
import React, { useState, useEffect } from "react";
import ReactPaginate from "react-paginate";
import { Col, Row, Table, Button } from "reactstrap";

function Proveedor() {
  const [proveedores, setProveedores] = useState([]);
  const [data, setData] = useState({});
  const [maxPages, setMaxPages] = useState(0);
  const [url, setUrl] = useState("/api/proveedors");

  useEffect(() => {
    axios.get(url).then((d) => {
      setData(d);
      setProveedores(d.data["hydra:member"]);
      if (d.data["hydra:view"] && d.data["hydra:view"]["hydra:last"]) {
        let p = d.data["hydra:view"]["hydra:last"].search("page=");
        let number = d.data["hydra:view"]["hydra:last"].slice(p + 5);
        p = number.indexOf("?");
        if (p === -1) {
          setMaxPages(parseInt(number));
        } else {
          number = number.slice(0, p);
          setMaxPages(parseInt(number));
        }
      }
    });
  }, [url]);

  function handlePageClick(event) {
    const pageSelected = event.selected + 1;
    setUrl(`/api/proveedors?page=${pageSelected}`);
  }

  function addProveedor() {
    console.log("clicked Add Proveedor");
  }

  const proveedoresEl = proveedores.map((proveedor) => {
    return (
      <tr key={proveedor["@id"]}>
        <td>{proveedor.ruc}</td>
        <td>{proveedor.nombre}</td>
        <td>{proveedor.contacto}</td>
        <td>{proveedor.telefono}</td>
        <td>{proveedor.email}</td>
      </tr>
    );
  });

  console.log(proveedoresEl);

  return (
    <>
      <Row>
        <Col md={{ offset: 2, size: 6 }}>
          <h3>Proveedor</h3>
        </Col>
        <Col md={2}>
          <Button color="primary" outline onClick={addProveedor}>
            Agregar
          </Button>
        </Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 6 }}>
          <ReactPaginate
            pageCount={maxPages}
            breakLabel="..."
            nextLabel=">>"
            onPageChange={handlePageClick}
            pageRangeDisplayed={3}
            previousLabel="<<"
            renderOnZeroPageCount={null}
            containerClassName="pagination pagination-sm"
            pageClassName="page-item"
            pageLinkClassName="page-link"
            previousClassName="page-item"
            nextClassName="page-item"
            previousLinkClassName="page-link"
            nextLinkClassName="page-link"
            activeLinkClassName="active"
            activeClassName="active"
          />
        </Col>
      </Row>
      <Row>
        <Col md={{ offset: 2, size: 8 }}>
          <Table hover size="sm">
            <thead>
              <tr>
                <td>RUC</td>
                <td>Nombre</td>
                <td>Contacto</td>
                <td>Teléfono</td>
                <td>E-mail</td>
              </tr>
            </thead>
            <tbody>{proveedoresEl}</tbody>
          </Table>
        </Col>
      </Row>
    </>
  );
}

export default Proveedor;
