import axios from "axios";
import React, { useState, useEffect } from "react";
import ReactPaginate from "react-paginate";
import moment from "moment";
import { Row, Col, Table } from "reactstrap";

function Facturas() {
  const [facturas, setFacturas] = useState([]);
  const [maxPages, setMaxPages] = useState(0);
  const [params, setParams] = useState({});
  const [isEdit, setIsEdit] = useState(false)
  const [showForm, setShowForm] = useState(false)
  const url = "/api/facturas";

  useEffect(() => {
    axios
      .get(url, { params })
      .then((d) => {
        setFacturas(d.data["hydra:member"]);
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
      })
      .catch((e) => console.log(e));
  }, [params]);

  function handlePageClick(event) {
    const pageSelected = event.selected + 1;
    setParams((prevParam) => ({ ...prevParam, page: pageSelected }));
  }

  function addFactura(event){
      event.preventDefault()
      setIsEdit(false)
      setShowForm(true)
  }

  const facturasEl = facturas.map((factura) => {
    return (
      <tr key={factura["@id"]}>
        <td>{factura.proveedor.nombre}</td>
        <td>{moment(factura.fecha).format("YYYY-MM-DD")}</td>
        <td>{factura.numero}</td>
        <td style={{ textAlign: "right" }}>{factura.total.toFixed(2)}</td>
      </tr>
    );
  });

  return (
    <>
      <Row>
        <Col md={{ offset: 2, size: 8 }}>
          <h3>Facturas</h3>
        </Col>
      </Row>
        <Col md={2}>
          <Button color="primary" outline onClick={addFactura}>
            Agregar
          </Button>
        </Col>
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
                <td>Proveedor</td>
                <td>Fecha</td>
                <td>Número</td>
                <td>Total</td>
              </tr>
            </thead>
            <tbody>{facturasEl}</tbody>
          </Table>
        </Col>
      </Row>
    </>
  );
}

export default Facturas;
